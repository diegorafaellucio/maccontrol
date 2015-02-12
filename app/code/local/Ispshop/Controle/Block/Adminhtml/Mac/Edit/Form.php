<?php

class Ispshop_Controle_Block_Adminhtml_Mac_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Init class
     */
    public function __construct() {
        parent::__construct();

        $this->setId('ispshop_controle_mac_form');
        $this->setTitle($this->__('MACs e Seriais'));
    }

    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $model = Mage::registry('ispshop_controle');
        $_resource = Mage::getSingleton('catalog/product')->getResource();


        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('checkout')->__('Informações de MACs e Seriais'),
        ));


        if ($model->getId()) {
            $hasMac = $_resource->getAttributeRawValue($model->getProductId(), 'has_mac', Mage::app()->getStore());
            $hasSerial = $_resource->getAttributeRawValue($model->getProductId(), 'has_serial', Mage::app()->getStore());
            $name = $_resource->getAttributeRawValue($model->getProductId(), 'name', Mage::app()->getStore());

            $fieldset->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
                'value' => $this->__($model->getId()),
            ));

            $fieldset->addField('product_name' . $model->getId(), 'note', array(
                'text' => $this->__($name),
                'label' => 'Produto',
            ));
            $fieldset->addField('order_id' . $model->getId(), 'hidden', array(
                'name' => 'order_id',
                'value' => $this->__($model->getOrderId()),
            ));
            $fieldset->addField('product_id' . $model->getId(), 'hidden', array(
                'name' => 'product_id',
                'value' => $this->__($model->getProductId()),
            ));
            $fieldset->addField('created_at' . $model->getId(), 'hidden', array(
                'name' => 'created_at',
                'value' => $this->__($model->getCreatedAt()),
            ));

            if ($hasMac == 1) {
                $fieldset->addField('mac' . $model->getId(), 'text', array(
                    'name' => 'mac',
                    'label' => Mage::helper('ispshop_controle')->__('MAC'),
                    'title' => Mage::helper('ispshop_controle')->__('MAC'),
                    'required' => false,
                    'value' => $model->getMac(),
                ));
            } else {
                $fieldset->addField('mac' . $model->getId(), 'hidden', array(
                    'name' => 'mac',
                    'value' => '',
                ));
            }

            if ($hasSerial == 1) {
                $fieldset->addField('serial' . $model->getId(), 'text', array(
                    'name' => 'serial',
                    'label' => Mage::helper('ispshop_controle')->__('Serial'),
                    'title' => Mage::helper('ispshop_controle')->__('Serial'),
                    'required' => false,
                    'value' => $model->getSerial(),
                ));
            } else {
                $fieldset->addField('serial' . $model->getId(), 'hidden', array(
                    'name' => 'serial',
                    'value' => '',
                ));
            }
        } else {

            $order = Mage::getModel('sales/order')->load($this->getRequest()->getParam('order_id'));
            $orderItems = $order->getItemsCollection();
            $order_date = Mage::getSingleton('core/date')->gmtDate();

            foreach ($orderItems as $item) {

                $product_id = $item->product_id;
                $product_name = $item->getName();
                $qty_ordered = $item->qty_ordered;
                $warranty_time = $_resource->getAttributeRawValue($product_id, 'warranty_time', Mage::app()->getStore());;

              

                $hasMac = $_resource->getAttributeRawValue($product_id, 'has_mac', Mage::app()->getStore());
                $hasSerial = $_resource->getAttributeRawValue($product_id, 'has_serial', Mage::app()->getStore());

                if ($hasMac == 1 || $hasSerial == 1) {

                    for ($index = 0; $index < $qty_ordered; $index++) {

                        $fieldset->addField('product_name' . $product_id . $index, 'note', array(
                            'text' => $this->__($product_name),
                            'label' => 'Produto',
                        ));
                        $fieldset->addField('order_id' . $product_id . $index, 'hidden', array(
                            'name' => 'order_id[]',
                            'value' => $this->getRequest()->getParam('order_id'),
                        ));
                        $fieldset->addField('customer_id' . $product_id . $index, 'hidden', array(
                            'name' => 'customer_id[]',
                            'value' => $this->__($order->getCustomerId()),
                        ));
                        $fieldset->addField('product_id' . $product_id . $index, 'hidden', array(
                            'name' => 'product_id[]',
                            'value' => $this->__($product_id),
                        ));
                        $fieldset->addField('created_at' . $product_id . $index, 'hidden', array(
                            'name' => 'created_at[]',
                            'value' => $this->__($order_date),
                        ));
                        $fieldset->addField('warranty_time' . $product_id . $index, 'hidden', array(
                            'name' => 'warranty_time[]',
                            'value' => $this->__($warranty_time),
                        ));

                        if ($hasMac == 1) {
                            $fieldset->addField('mac' . $product_id . $index, 'text', array(
                                'name' => 'mac[]',
                                'label' => Mage::helper('ispshop_controle')->__('MAC'),
                                'title' => Mage::helper('ispshop_controle')->__('MAC'),
                                'required' => false,
                            ));
                        } else {
                            $fieldset->addField('mac' . $product_id . $index, 'hidden', array(
                                'name' => 'mac[]',
                                'value' => '',
                            ));
                        }

                        if ($hasSerial == 1) {
                            $fieldset->addField('serial' . $product_id . $index, 'text', array(
                                'name' => 'serial[]',
                                'label' => Mage::helper('ispshop_controle')->__('Serial'),
                                'title' => Mage::helper('ispshop_controle')->__('Serial'),
                                'required' => false,
                            ));
                        } else {
                            $fieldset->addField('serial' . $product_id . $index, 'hidden', array(
                                'name' => 'serial[]',
                                'value' => '',
                            ));
                        }
                    }
                }
            }
        }

        if ($model->getEntitytId()) {
            $form->setValues($model->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
