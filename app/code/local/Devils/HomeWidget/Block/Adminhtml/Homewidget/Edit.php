<?php

class Devils_HomeWidget_Block_Adminhtml_Homewidget_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'devils_homewidget';
        $this->_headerText = $this->__('Home Widget Image Edit');
        $this->_controller = 'adminhtml_homewidget';
        $this->_addButton('saveandcontinue', array(
            'label'     => $this->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
}
