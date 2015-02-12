<?php

class Ispshop_Controle_Customer_MacController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        $this->loadLayout();
        $this->renderLayout();
    }

    private function warrantyFinished($startDate, $endDate, $warrantyTime) {
        $time_inicial = strtotime($startDate);
        $time_final = strtotime($endDate);

        $diferenca = $time_final - $time_inicial; // 19522800 segundos
        $dias = (int) floor($diferenca / (60 * 60 * 24)); // 225 dias

        if ($dias < $warrantyTime) {
            return false;
        } else {
            return true;
        }
    }

    public function searchAction() {
        $result = '';
        $customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $searchString = $this->getRequest()->getParam('stringSearch');


        $collection = Mage::getModel('ispshop_controle/mac')->getCollection()
                ->addFieldToFilter('main_table.customer_id', array('eq' => $customer_id))
                ->addFieldToFilter(
                array('increment_id', 'serial', 'mac'), array(
            array('like' => '%' . $searchString . '%'),
            array('like' => '%' . $searchString . '%'),
            array('like' => '%' . $searchString . '%'),
                )
        );
        
        $collection->join(array('order' => 'sales/order'), 'main_table.order_id = order.entity_id', array('increment_id'));

        foreach ($collection as $mac) {

            if ($this->warrantyFinished($mac->getData('created_at'), Mage::getSingleton('core/date')->gmtDate(), $mac->getData('warranty_time'))) {
                $status = '<span style="color:#cc0000;">A garantia terminou</span>';
            } else {
                $status = '<span style="color:#00cc00;">Garantia válida</span>';
            }

            $result .= '<tr>';
            $result .= '<td>' . $mac->getData('increment_id') . '</td>';
            $result .= '<td>' . Mage::getSingleton('catalog/product')->getResource()->getAttributeRawValue($mac->getData('product_id'), 'name', Mage::app()->getStore()) . '</td>';
            $result .= '<td>' . Mage::helper('core')->formatDate($mac->getData('created_at')) . '</td>';
            $result .= '<td>' . $mac->getData('mac') . '</td>';
            $result .= '<td>' . $mac->getData('serial') . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '</tr>';
        }
        echo $result;
    }

}
