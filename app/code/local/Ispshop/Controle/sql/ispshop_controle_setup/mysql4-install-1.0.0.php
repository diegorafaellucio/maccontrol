<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'ispshop_controle_mac'
 */
$table = $installer->getConnection()
        // The following call to getTable('ispshop_controle/mac') will lookup the resource for ispshop_controle (ispshop_controle_mysql4), and look
        // for a corresponding entity called mac. The table name in the XML is ispshop_controle_mac, so this is what is created.
        ->newTable($installer->getTable('ispshop_controle/mac'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
                ), 'entity_id')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
            'nullable' => false,
                ), 'order_id')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
            'nullable' => false,
                ), 'customer_id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
            'nullable' => false,
                ), 'product_id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, 0, array(
            'nullable' => false,
                ), 'created_at')
        ->addColumn('warranty_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
                ), 'warranty')
        ->addColumn('mac', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
                ), 'mac')
        ->addColumn('serial', Varien_Db_Ddl_Table::TYPE_VARCHAR, 0, array(
        ), 'Serial');
$installer->getConnection()->createTable($table);


$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_product', 'has_mac', array(
    'label' => 'Possui MAC?',
    //'group'        => 'General',
    'visible' => 0,
    'required' => 1,
    'user_defined' => 0,
    'position' => 1,
    'source' => 'eav/entity_attribute_source_boolean',
    'type' => 'int',
    'input' => 'boolean',
    'default' => '0',
));


$setup->addAttribute('catalog_product', 'has_serial', array(
    'label' => 'Possui Serial?',
    //'group'        => 'General',
    'visible' => 0,
    'required' => 1,
    'user_defined' => 0,
    'position' => 2,
    'source' => 'eav/entity_attribute_source_boolean',
    'type' => 'int',
    'input' => 'boolean',
    'default' => '0',
));

$setup->addAttribute('catalog_product', 'warranty_time', array(
    'label' => 'Tempo de garantia',
    //'group'        => 'General',
    'visible' => 0,
    'required' => 1,
    'user_defined' => 0,
    'position' => 3,
    'type' => 'int',
    'input' => 'text',
    'value' => '90',
    'class' => 'validate-digits',
));


$installer->endSetup();
