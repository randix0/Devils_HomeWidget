<?php

class Devils_HomeWidget_Block_Adminhtml_HomeWidget_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct() {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'devils_homewidget';
        $this->_headerText = $this->__('Home Widget Image Edit');
        $this->_controller = 'adminhtml_homewidget';
    }
}