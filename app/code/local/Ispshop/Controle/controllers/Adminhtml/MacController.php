<?php

class Ispshop_Controle_Adminhtml_MacController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
                ->renderLayout();
    }

    public function newAction() {
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }

    public function deleteAction() {
        $this->_initAction();

        // Get id if available

        $order_id = $this->getRequest()->getParam('order_id');
        $model = Mage::getModel('ispshop_controle/mac');
        $collection = $model->getCollection()->addFieldToFilter('order_id', $order_id);



        if ($order_id) {

            foreach ($collection as $mac) {
                $entity_id = $mac->getId();
                $model->load($entity_id);
                $model->delete();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Os MACs e Seriais foram removidos com sucesso.'));
            $this->_redirect('*/sales_order/view/order_id/' . $order_id);

            return;
        }
    }

    public function editAction() {
        $this->_initAction();

        // Get id if available

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ispshop_controle/mac');

        if ($id) {
            // Load record
            $model->load($id);

            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Este Mac não existe.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('Novo Mac'));

        $data = Mage::getSingleton('adminhtml/session')->getMacData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('ispshop_controle', $model);

        $this->_initAction()
                ->_addBreadcrumb($id ? $this->__('Editar MACs e Seriais') : $this->__('Novos MACs e Seriais'), $id ? $this->__('Editar MACs e Seriais') : $this->__('Novos MACs e Seriais'))
                ->_addContent($this->getLayout()->createBlock('ispshop_controle/adminhtml_mac_edit')->setData('action', $this->getUrl('*/*/save')))
                ->renderLayout();
    }

    public function saveAction() {
        if ($postData = $this->getRequest()->getPost()) {

            $redirect_link = '';
            $order_id = $postData['order_id'];
            $product_id = $postData['product_id'];
            $createdAt = $postData['created_at'];
            $warranty_time = $postData['warranty_time'];
            $customer_id = $postData['customer_id'];
            $mac = $postData['mac'];
            $serial = $postData['serial'];


            try {
                if (isset($postData['entity_id'])) {
                    $redirect_link = '*/sales_order/view/order_id/' . $postData['order_id'];
                    $model = Mage::getSingleton('ispshop_controle/mac');
                    $model->setData($postData);

                    $model->save();
                } else {
                    $redirect_link = '*/sales_order/view/order_id/' . $order_id[0];
                    for ($index = 0; $index < count($postData['created_at']); $index++) {

                        $data = array('form_key' => $postData['form_key'], 'order_id' => $order_id[$index], 'product_id' => $product_id[$index],'customer_id' => $customer_id[$index], 'created_at' => $createdAt[$index], 'warranty_time' => $warranty_time[$index], 'mac' => $mac[$index], 'serial' => $serial[$index]);

                        $model = Mage::getSingleton('ispshop_controle/mac');
                        $model->setData($data);

                        $model->save();
                    }
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Os MACs e Seriais foram cadastrados com sucesso.'));
                $this->_redirect($redirect_link);
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Um erro ocorreu enquanto os MACs e Seriais estavam sendo salvos'));
            }
        }

        Mage::getSingleton('adminhtml/session')->setMACData($postData);
        $this->_redirectReferer();
    }

    public function messageAction() {
        $data = Mage::getModel('ispshop_controle/mac')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }

    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction() {
        $this->loadLayout()
                // Make the active menu match the menu config nodes (without 'children' inbetween)
                ->_setActiveMenu('sales/ispshop_controle_mac')
                ->_title($this->__('Sales'))->_title($this->__('Controle de MACs e Seriais'))
                ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
                ->_addBreadcrumb($this->__('MAC'), $this->__('Controle de MACs e Seriais'));

        return $this;
    }

    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('sales/ispshop_controle_mac');
    }

}
