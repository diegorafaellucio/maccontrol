<?php
class Ispshop_Controle_Model_Mysql4_Mac extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {  
        $this->_init('ispshop_controle/mac', 'entity_id');
    }  
}