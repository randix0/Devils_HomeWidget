<?php

class Devils_HomeWidget_Block_Adminhtml_HomeWidget_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('devils_homewidget_grid');
        $this->setUseAjax(true);
    }

    protected function _prepareColumns() {
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
        $this->addColumn('link', array(
            'header' => $this->__('Link'),
            'type'   => 'text',
            'index'  => 'link',
            'escape' => true
        ));
        $this->addColumn('position', array(
            'header' => $this->__('Sort Order'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'position'
        ));
        $this->addColumn('active', array(
            'header'    => $this->__('Active'),
            'align'     => 'center',
            'width'     => 1,
            'index'     => 'active',
            'type'      => 'options',
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            ),
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('devils_homewidget/image_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
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