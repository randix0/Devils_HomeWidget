<?php

class Devils_HomeWidget_Adminhtml_HomeWidgetController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('devils/devils_homewidget');
    }

    public function indexAction()
    {
        $this->_redirect('*/*/list');
    }

    public function listAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('devils/devils_homewidget');
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_initImage('id');
        if (!$model->getId() && $id) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('devils_homewidget')->__('This distributor no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Image'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->loadLayout();
        $this->_setActiveMenu('devils/devils_homewidget');
        $breadcrumbMessage = $id ? Mage::helper('devils_homewidget')->__('Edit Image')
            : Mage::helper('devils_homewidget')->__('New Image');
        $this->_addBreadcrumb($breadcrumbMessage, $breadcrumbMessage)
            ->renderLayout();
    }

    protected function _initImage($idFieldName = 'entity_id')
    {
        $this->_title($this->__('Catalog'))->_title($this->__('Image'));
        $id = (int)$this->getRequest()->getParam($idFieldName);
        $model = Mage::getModel('devils_homewidget/image');
        if ($id) {
            $model->load($id);
        }
        if (!Mage::registry('current_image')) {
            Mage::register('current_image', $model);
        }
        return $model;
    }

    public function saveAction()
    {
        /** @var Devils_HomeWidget_Helper_Data $helper */
        $helper = Mage::helper('devils_homewidget');
        if ($data = $this->getRequest()->getPost()) {
            $image = $this->_initImage();
            $result = null;
            $isUploaded = true;

            try {
                /** @var $uploader Mage_Core_Model_File_Uploader */
                $uploader = Mage::getModel('core/file_uploader', 'image');
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setAllowCreateFolders(true);
                $uploader->setFilesDispersion(false);
            } catch (Exception $e) {
                $isUploaded = false;
            }

            $deleteImage = false;
            if (isset($data['image']['delete'])) {
                $deleteImage = true;
            }
            unset($data['image']);

            $sizeData = explode('x', $data['size_code']);
            $data['width'] = (int) $sizeData[0];
            $data['height'] = (int) $sizeData[1];

            $image->addData($data);

            if ($deleteImage) {
                $image->setImage('');
            }
            try {
                $image->save();
                $imageId = $image->getId();
            } catch (Exception $e) {
                return $this->_redirect('*/*/');
            }

            if ($isUploaded) {
                $imageFullPath = $helper->getImageFullPath($imageId . DS);
                $result = $uploader->save($imageFullPath);
                $image->setImage($imageId . DS . $result['file']);
                $image->save();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('devils_homewidget')->__('%s was successfully saved', $image->getName())
            );

            if ($this->getRequest()->getParam('back')) {
                $params = array('id' => $image->getId());
                $this->_redirect('*/*/edit', $params);
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        /** @var Devils_HomeWidget_Helper_Data $helper */
        $helper = Mage::helper('devils_homewidget');
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $id = $this->getRequest()->getParam('id');
                $image = Mage::getModel('devils_homewidget/image');
                $image->setId($id)->delete();
                $imagePath = $helper->getImagePath($id);
                $cachePath = $helper->getImageCachePath($id);
                $this->_clearDir($imagePath);
                $this->_clearDir($cachePath);
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Image was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function switchImageSetsAction()
    {
        /** @var Devils_HomeWidget_Model_Resource_Image $resource */
        $resource = Mage::getResourceModel('devils_homewidget/image');
        try {
            $resource->switchImageSets();
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*/');
    }

    protected function _clearDir($dir)
    {
        if(file_exists($dir)){
            $glob = glob($dir . '/*');
            if($glob){
                foreach($glob as $file){
                    if(is_dir($file)){
                        $this->_clearDir($file);
                    }else{
                        unlink($file);
                    }
                }
                rmdir($dir);
            }
        }
        return $this;
    }
}