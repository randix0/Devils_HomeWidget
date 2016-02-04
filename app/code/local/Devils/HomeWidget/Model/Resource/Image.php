<?php

class Devils_HomeWidget_Model_Resource_Image extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct() {
        $this->_init('devils_homewidget/images_source', 'entity_id');
    }
}