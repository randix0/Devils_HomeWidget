<?php

class Devils_HomeWidget_Block_Adminhtml_HomeWidget_Edit_Tab_Areas extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('devils/homewidget/form/areas.phtml');
    }

    public function getFormData()
    {
        /** @var Devils_HomeWidget_Helper_Data $helper */
        $helper = Mage::helper('devils_homewidget');

        $image = Mage::registry('current_image');
        $imageData = $image->getData();
        if ($image->getId()) {
            $imageFile = $image->getData();
            $width = $image->getWidth();
            $height = $image->getHeight();
            $resizeMode = $image->getResizeMode();
            if (!empty($image)) {
                $url = $helper->getResizedImage($imageFile['image'], $width, $height, $resizeMode);
                $imageData['src'] = $url;
            }
        }
        return $imageData;
    }

}