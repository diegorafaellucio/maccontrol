<?php
class Ispshop_Controle_Block_Adminhtml_Mac extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        // The blockGroup must match the first half of how we call the block, and controller matches the second half
        // ie. foo_bar/adminhtml_baz
        $this->_blockGroup = 'ispshop_controle';
        $this->_controller = 'adminhtml_mac';
        $this->_headerText = $this->__('Controle de MACs e Seriais');
        
        parent::__construct();

    }
    
    public function _prepareLayout() {
        parent::_prepareLayout();
                        
        $this->removeButton('add');
    }
}