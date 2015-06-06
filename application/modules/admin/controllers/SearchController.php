<?php

require_once 'AuthController.php';

class Admin_SearchController extends Admin_AuthController
{
    public function informationAction()
    {
        $form = new Admin_Form_SearchDeviceByInformation();

        if ($this->_request->get('search')) {
            // Get value
            $attribute_id = $this->_request->getQuery('attribute_id');
            $value_id = $this->_request->getQuery('value_id');
            $type = $this->_request->getQuery('type');
            $name = $this->_request->getQuery('name');
            $country = $this->_request->getQuery('country');
            $factory = $this->_request->getQuery('factory');
            $cost_min = $this->_request->getQuery('cost_min');
            $cost_max = $this->_request->getQuery('cost_max');

            // Populate form
            $form->populate(compact('attribute_id', 'value_id', 'type', 'name', 'country', 'factory', 'cost_min', 'cost_max'));

            // Do search here
            $mDevice = new Admin_Model_Device();
            $mDeviceDetail = new Admin_Model_DeviceDetail();
            $mFactory = new Admin_Model_Factory();

            $devices = $mDevice->searchByInformation($attribute_id, $value_id, $type, $name, $country, $factory, $cost_max, $cost_min);
            $deviceDetails = $mDeviceDetail->findListByDeviceIds($mDevice->getIdsFromList($devices));

            $paginator = Zend_Paginator::factory($deviceDetails);
            $paginator->setItemCountPerPage(20);
            $paginator->setPageRange(20);
            $currentPage = $this->_request->getParam('page',1);
            $paginator->setCurrentPageNumber($currentPage);

            $this->view->data = $paginator;
            $this->view->controller = $this;
        }

        $this->view->form = $form;
    }

    public function addressAction()
    {
        $form = new Admin_Form_SearchDeviceByAddress();

        if ($this->_request->get('search')) {
            // Get value
            $room = $this->_request->getQuery('room');
            $building = $this->_request->getQuery('building');
            $institute = $this->_request->getQuery('institute_id');
            $department = $this->_request->getQuery('department_id');

            // Populate form
            $form->populate(compact('room', 'building', 'institute_id', 'department_id'));

            // Do search here
            $mDevice = new Admin_Model_Device();
            $mDeviceDetail = new Admin_Model_DeviceDetail();
            $mFactory = new Admin_Model_Factory();

            $paginator = Zend_Paginator::factory($mDeviceDetail->searchByAddress($room, $building, $department, $institute));
            $paginator->setItemCountPerPage(20);
            $paginator->setPageRange(20);
            $currentPage = $this->_request->getParam('page',1);
            $paginator->setCurrentPageNumber($currentPage);
            $this->view->data = $paginator;
            $this->view->controller = $this;
        }

        $this->view->form = $form;
    }

    public function getDevice($id){
        $mdevice=new Admin_Model_Device();
        return $mdevice->getInfo($id);
    }

    public function getInfo($id){
        $mdetail = new Admin_Model_DeviceDetail();
        return $mdetail->getInfo($id);
    }

    public function getUnit($no){
        $unit = substr($no, 0, 6);
        if(substr($unit, 4, 2)== '00'){
          $mInstitute = new Admin_Model_Institute;
          return $mInstitute->getBySign($unit);
        }
        else{
          $mDepartment = new Admin_Model_Department;
          return $mDepartment->getBySign($unit);
        }
    }
}