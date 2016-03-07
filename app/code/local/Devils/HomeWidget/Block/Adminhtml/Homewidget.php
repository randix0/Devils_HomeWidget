<?php

class Devils_HomeWidget_Block_Adminhtml_Homewidget extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        $this->_addButton('switch_image_sets', array(
            'label'     => Mage::helper('catalogrule')->__('Switch Image Sets'),
            'onclick'   => "location.href='".$this->getUrl('*/*/switchImageSets')."'",
            'class'     => '',
        ));

        $this->_blockGroup = 'devils_homewidget';
        $this->_controller = 'adminhtml_homewidget';
        $this->_headerText = $this->__('Home Widget Images List');
        $this->_addButtonLabel = $this->__('Add Image');
        parent::_construct();
    }
}
