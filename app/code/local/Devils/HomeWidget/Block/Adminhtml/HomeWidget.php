<?php

class Devils_HomeWidget_Block_Adminhtml_HomeWidget extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'devils_homewidget';
        $this->_controller = 'adminhtml_homewidget';
        $this->_headerText = $this->__('Home Widget Images List');
        $this->_addButtonLabel = $this->__('Add Image');
        parent::_construct();
    }
}