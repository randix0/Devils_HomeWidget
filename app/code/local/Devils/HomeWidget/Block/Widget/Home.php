<?php

class Devils_HomeWidget_Block_Widget_Home extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    public function getItems()
    {
        /** @var Devils_HomeWidget_Model_Resource_Image_Collection $collection */
        $collection = Mage::getModel('devils_homewidget/image')->getCollection();
        $collection->addFieldToFilter('active', 1)->setOrder('position', 'ASC');;

        return $collection;
    }
}