<?php


class Devils_HomeWidget_Block_Adminhtml_HomeWidget_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        /** @var Devils_HomeWidget_Helper_Data $helper */
        $helper = Mage::helper('devils_homewidget');
        $model  = Mage::registry('current_image');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save',
                $this->getRequest()->getParam('id')),
            'method' => 'post',
            'enctype'=> 'multipart/form-data'
        ));
        $fieldset = $form->addFieldset('general_form', array(
            'legend' => $this->__('General Setup')
        ));

        $fieldset->addType('thumbnail','Devils_HomeWidget_Model_Varien_Data_Form_Element_Thumbnail');

        $fieldset->addField('name', 'text', array(
            'label' => $this->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name'
        ));
        $fieldset->addField('image', 'image', array(
                'label' => $this->__('Image'),
                'scope' => 'store',
                'name'  => 'image'
            )
        );
        $fieldset->addField('link', 'text', array(
            'label' => $this->__('Link'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'link'
        ));
        $fieldset->addField('size_code', 'select', array(
            'label' => $this->__('Size'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'size_code',
            'options' => $helper->getAvailableSizes()
        ));
        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => $this->__('Sort Order'),
            'class'     => 'validate-not-negative-number',
            'value'     => (int) $model->getPosition(),
            'required'  => true,
        ));
        $fieldset->addField('active', 'select', array(
            'label' => $this->__('Active'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'active',
            'options' => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        ));
        $fieldset->addField('thumbnail', 'thumbnail', array(
            'label'     => $this->__('Thumbnail'),
            'name'      => 'thumbnail',
            'style'   => "display:none;",
        ));
        $image = Mage::registry('current_image');
        if ($image->getId()) {
            $form->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
            ));
            $form->setValues($image->getData());
            $imageFile = $form->getElement('image')->getValue();
            $width = $image->getWidth();
            $height = $image->getHeight();
            if (!empty($image)) {
                $form->getElement('image')->setValue($helper->getImageUrl($imageFile));
                $form->getElement('thumbnail')->setValue($helper->getResizedImage($imageFile, $width, $height));
            }
        }
        $form->setUseContainer(true);
        $form->addValues($this->_getFormData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    protected function _getFormData()
    {
        $data = Mage::getSingleton('adminhtml/session')->getFormData();
        return $data;
    }
}
