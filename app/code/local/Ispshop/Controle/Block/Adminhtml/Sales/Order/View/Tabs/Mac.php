<?php

/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento community edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento community edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Helpdeskultimate
 * @version    2.10.5
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */
class Ispshop_Controle_Block_Adminhtml_Sales_Order_View_Tabs_Mac extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface {

    /**
     * Reference to product objects that is being edited
     *
     * @var Mage_Catalog_Model_Product
     */
    protected $_product = null;
    protected $_config = null;

    /**
     * Get tab label
     *
     * @return string
     */
    public function getTabLabel() {
        return Mage::helper('ispshop_controle')->__('Controle de Macs e Seriais');
    }

    public function getTabTitle() {
        return Mage::helper('ispshop_controle')->__('Controle de Macs e Seriais');
    }

    public function canShowTab() {
        return true;
    }

    /**
     * Check if tab is hidden
     *
     * @return boolean
     */
    public function isHidden() {
        return false;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml() {
        $id = $this->getRequest()->getParam('order_id');
        $collection = Mage::getModel('ispshop_controle/mac')->getCollection()->addFieldToFilter('order_id', $id);
        $macNewUrl = $this->getUrl('/mac/new', array('order_id' => $id));
        $macDeleteUrl = $this->getUrl('/mac/delete', array('order_id' => $id));
        $buttonAdd = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setClass('add')
                ->setType('button')
                ->setOnClick('window.location.href=\'' . $macNewUrl . '\'')
                ->setLabel($this->__('Cadastrar Macs e Seriais'));
        $buttonAdd->setStyle('margin:10px;float:none;clear:both;');
        $buttonDelete = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setClass('delete')
                ->setType('button')
                ->setOnClick('window.location.href=\'' . $macDeleteUrl . '\'')
                ->setLabel($this->__('Remover TODOS Macs e Seriais'));
        $buttonDelete->setStyle('margin:10px;float:none;clear:both;');
        $grid = $this->getLayout()->createBlock('ispshop_controle/adminhtml_mac_grid');
        $grid->setDefaultFilter(array('order_id' => $id));
        $grid->setCollection($collection);
        $grid->setFilterVisibility(false);
        $grid->setPagerVisibility(0);
        $grid->setUserMode();
        $grid->setOrderMode(1);
        $grid->setStoreSwitcherVisibility(false);
        $grid->setOnePage();

        $canInsertMacAndSerial = Mage::getSingleton('admin/session')->isAllowed('admin/sales/ispshop_controle_mac/pode_cadastrar');
        $canDeleteMacAndSerial = Mage::getSingleton('admin/session')->isAllowed('admin/sales/ispshop_controle_mac/pode_excluir');

        if ($canInsertMacAndSerial && $canDeleteMacAndSerial) {
            if ($collection->getSize() > 0) {
                return $buttonDelete->toHtml() . $grid->toHtml();
            } else {
                return $buttonAdd->toHtml() . $grid->toHtml();
            }
        } else if ($canInsertMacAndSerial) {
            if (!$collection->getSize() > 0) {
                return $buttonAdd->toHtml() . $grid->toHtml();
            }
        } else if ($canDeleteMacAndSerial) {
            if ($collection->getSize() > 0) {
                return $buttonDelete->toHtml() . $grid->toHtml();
            }
        } else {
            return $grid->toHtml();
        }
    }

}
