<?php

class Ispshop_Controle_Block_Adminhtml_Mac_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();

        // Set some defaults for our grid
        $this->setDefaultSort('id');
        $this->setId('ispshop_controle_mac_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _getCollectionClass() {
        // This is the model we are using for the grid
        return 'ispshop_controle/mac_collection';
    }

    protected function _prepareCollection() {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        
        $collection->join(array('order' => 'sales/order'), 'main_table.order_id = order.entity_id', array('increment_id'));
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        // Add the columns that should appear in the grid
        $this->addColumn('entity_id', array(
            'header' => $this->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id'
                )
        );
      
        $this->addColumn('increment_id', array(
            'header' => $this->__('Pedido'),
            'index' => 'increment_id'
                )
        );        

        $this->addColumn('product_id', array(
            'header' => $this->__('Produto'),
            'index' => 'product_id'
                )
        );

        $this->addColumn('created_at', array(
            'header' => $this->__('Cadastrado em'),
            'index' => 'created_at',
            'type' => 'datetime'
                )
        );

        $this->addColumn('mac', array(
            'header' => $this->__('MAC'),
            'index' => 'mac'
                )
        );

        $this->addColumn('serial', array(
            'header' => $this->__('Serial'),
            'index' => 'serial'
                )
        );


        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        // This is where our row data will link to

        $canEditMacAndSerial = Mage::getSingleton('admin/session')->isAllowed('admin/sales/ispshop_controle_mac/pode_editar');

        if ($canEditMacAndSerial) {
            return $this->getUrl('*/mac/edit', array('id' => $row->getEntityId()));
        }else{
            return;
        }
        
    }

}
