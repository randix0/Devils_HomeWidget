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
        $this->_init('devils_homewidget/image', 'entity_id');
        $this->_imagesTable = $this->getTable('devils_homewidget/image');
    }

    public function switchImageSets()
    {
        $write  = $this->_getWriteAdapter();
        $rowsCount = $write->update($this->_imagesTable, array('is_active' => new Zend_Db_Expr('!is_active')));
        return $rowsCount > 0;
    }

    /**
     * Perform operations after object load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Devils_HomeWidget_Model_Resource_Image
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
            $areas = $this->lookupAreas($object->getId());
            $object->setData('areas', $areas);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Devils_HomeWidget_Model_Image $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('dhis' => $this->getTable('devils_homewidget/image_store')),
                $this->getMainTable() . '.entity_id = dhis.entity_id',
                array())
                ->where('is_active = ?', 1)
                ->where('dhis.store_id IN (?)', $storeIds)
                ->order('dhis.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Process image data before deleting
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Devils_HomeWidget_Model_Resource_Image
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'entity_id = ?'     => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('devils_homewidget/image_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('devils_homewidget/image_store'), 'store_id')
            ->where('entity_id = ?',(int) $id);

        return $adapter->fetchCol($select);
    }

    /**
     * Get item maps areas
     *
     * @param int $id
     * @return array
     */
    public function lookupAreas($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('devils_homewidget/image_area'))
            ->where('entity_id = ?',(int) $id);

        return $adapter->fetchAll($select);
    }

    /**
     * Assign image to store views
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Devils_HomeWidget_Model_Resource_Image
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $entityId = (int) $object->getId();
        $oldStores = $this->lookupStoreIds($entityId);
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('devils_homewidget/image_store');
        $insertStores = array_diff($newStores, $oldStores);
        $deleteStores = array_diff($oldStores, $newStores);

        if ($deleteStores) {
            $where = array(
                'entity_id = ?'     => $entityId,
                'store_id IN (?)' => $deleteStores
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insertStores) {
            $data = array();

            foreach ($insertStores as $storeId) {
                $data[] = array(
                    'entity_id'  => $entityId,
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        $areas = $object->getAreas();
        $table  = $this->getTable('devils_homewidget/image_area');

        $where = array(
            'entity_id = ?'     => $entityId,
        );

        $this->_getWriteAdapter()->delete($table, $where);
        foreach ($areas as &$area) {
            $area['entity_id'] = $entityId;
        }
        $this->_getWriteAdapter()->insertMultiple($table, $areas);

        //Mark layout cache as invalidated
        Mage::app()->getCacheInstance()->invalidateType('layout');

        return parent::_afterSave($object);
    }
}
