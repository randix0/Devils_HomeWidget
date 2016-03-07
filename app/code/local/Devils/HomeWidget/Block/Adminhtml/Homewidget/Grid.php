<?php

class Devils_HomeWidget_Block_Adminhtml_Homewidget_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('devils_homewidget_grid');
        $this->setUseAjax(true);
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => $this->__('ID'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header' => $this->__('Name'),
            'type'   => 'text',
            'index'  => 'name',
            'escape' => true
        ));

        $this->addColumn('url_path', array(
            'header' => $this->__('URL Path'),
            'type'   => 'text',
            'index'  => 'url_path',
            'escape' => true
        ));

        $this->addColumn('size_code', array(
            'header' => $this->__('Size Code'),
            'type'   => 'text',
            'index'  => 'size_code',
            'width'  => '60px',
            'escape' => true
        ));

        $this->addColumn('resize_mode', array(
            'header'    => $this->__('Resize mode'),
            'align'     => 'center',
            'width'     => 1,
            'index'     => 'resize_mode',
            'type'      => 'options',
            'options'   => array(
                'cover' => $this->__('Cover'),
                'contain' => $this->__('Contain')
            ),
        ));

        $this->addColumn('position', array(
            'header' => $this->__('Sort Order'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'position'
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('cms')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('is_active', array(
            'header'    => $this->__('Is Image Active'),
            'align'     => 'center',
            'width'     => 1,
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            ),
        ));
        return parent::_prepareColumns();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('devils_homewidget/image_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
