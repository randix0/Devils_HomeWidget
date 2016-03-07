<?php

class Devils_HomeWidget_Block_Adminhtml_Homewidget_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('adminhtml')->__('User Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main_section', array(
            'label'     => Mage::helper('adminhtml')->__('Image Info'),
            'title'     => Mage::helper('adminhtml')->__('Image Info'),
            'content'   => $this->getLayout()->createBlock('devils_homewidget/adminhtml_homeWidget_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $this->addTab('areas_section', array(
            'label'     => Mage::helper('adminhtml')->__('Image Map Areas'),
            'title'     => Mage::helper('adminhtml')->__('Image Map Areas'),
            'content'   => $this->getLayout()->createBlock('devils_homewidget/adminhtml_homeWidget_edit_tab_areas',
                'homeWidgetAreas')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}