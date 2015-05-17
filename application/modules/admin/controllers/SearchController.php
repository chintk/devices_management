<?php

require_once 'AuthController.php';

class Admin_SearchController extends Admin_AuthController
{
    public function informationAction()
    {
        $form = new Admin_Form_SearchDeviceByInformation();

        if ($this->_request->get('search')) {
            // Get value
            $attributeId = $this->_request->getQuery('attributeId');
            $attributeValueId = $this->_request->getQuery('attributeValueId');

            // Populate form
            $form->populate(compact('attributeId', 'attributeValueId'));

            // Do search here
            $mDevice = new Admin_Model_Device();
            $mDeviceDetail = new Admin_Model_DeviceDetail();
            $mFactory = new Admin_Model_Factory();

            $paginator = Zend_Paginator::factory($mDevice->searchByInformation($attributeId, $attributeValueId));
            $paginator->setItemCountPerPage(10);
            $paginator->setPageRange(10);
            $currentPage = $this->_request->getParam('page',1);
            $paginator->setCurrentPageNumber($currentPage);

            $this->view->data = $paginator;
            $this->view->deviceDetails = $mDeviceDetail->findListByDeviceIds($mDevice->getIdsFromList($paginator));
            $this->view->factories = $mFactory->makeList($mFactory->index());
        }

        $this->view->form = $form;
    }
}