<?php

class Devils_HomeWidget_Model_Varien_Data_Form_Element_Thumbnail extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }

    public function getElementHtml()
    {
        $html = '';
        if ($this->getValue()) {
            $html = '<a onclick="imagePreview(\'' . $this->getHtmlId() . '_image\'); return false;" href="'
                . $this->getValue() . '"><img id="' . $this->getHtmlId()
                . '_image" title="' . $this->getValue() . '" src="'
                . $this->getValue() . '" alt="' . $this->getValue() . '"></a>';
        }
        $this->setClass('input-file');
        $html.= parent::getElementHtml();
        return $html;
    }

    protected function _getUrl()
    {
        return $this->getValue();
    }

    public function getName()
    {
        return  $this->getData('name');
    }
}
