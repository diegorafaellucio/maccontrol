<?php

class Ispshop_Controle_Block_Customer_Mac extends Mage_Core_Block_Template {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareLayout() {
        $head = $this->getLayout()->getBlock('head');
        $head->setTitle('Controle de MACs e Seriais');

        return parent::_prepareLayout();
    }

}
