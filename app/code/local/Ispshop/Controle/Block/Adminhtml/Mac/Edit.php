<?php
class Ispshop_Controle_Block_Adminhtml_Mac_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'ispshop_controle';
        $this->_controller = 'adminhtml_mac';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Salvar Informação de MACs e Seriais'));
        $this->_removeButton('delete');
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('ispshop_controle')->getId()) {
            return $this->__('Editar Informação de MACs e Seriais');
        }  
        else {
            return $this->__('Novas Informações de MACs e Seriais');
        }  
    }  
}