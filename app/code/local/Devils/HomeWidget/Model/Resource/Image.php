<?php

class Devils_HomeWidget_Model_Resource_Image extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Images table
     *
     * @var string
     */
    protected $_imagesTable;

    protected function _construct()
    {
        $this->_init('devils_homewidget/images_source', 'entity_id');
        $this->_imagesTable = $this->getTable('devils_homewidget/images_source');
    }

    public function switchImageSets()
    {
        $write  = $this->_getWriteAdapter();
        $rowsCount = $write->update($this->_imagesTable, array('active' => new Zend_Db_Expr('!active')));
        return $rowsCount > 0;
    }
}
