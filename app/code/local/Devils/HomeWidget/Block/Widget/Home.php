<?php

class Devils_HomeWidget_Block_Widget_Home extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    public function getItems()
    {
        /** @var Devils_HomeWidget_Model_Resource_Image_Collection $collection */
        $collection = Mage::getModel('devils_homewidget/image')->getCollection();
        $store = Mage::app()->getStore();
        $collection
            ->addStoreFilter($store)
            ->addFieldToFilter('is_active', 1)
            ->setOrder('position', 'ASC')
            ->setOrder('entity_id', 'ASC')
            ->walk('afterLoad');

        return $collection;
    }
}
