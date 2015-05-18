<?php
require_once 'AuthController.php';
class Admin_DisposalController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Disposals");
    $mdisposal=new Admin_Model_Disposal;
    $paginator = Zend_Paginator::factory($mdisposal->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create disposal");
    $form = new Admin_Form_CreateDisposal();
    $mdisposal = new Admin_Model_Disposal;
    $form->disposal_date->setValue(date('Y-m-d'));
    $this->setSeclectProvider($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $disposal_date = $request->getParam('disposal_date');
        $description = $request->getParam('description');
        $provider_id = $request->getParam('provider_id');
        $data = array ('disposal_date' => $disposal_date, 'description' => $description,
          'provider_id'=>$provider_id);
        if($mdisposal->create($data)){
          $this->_redirect('/admin/disposal/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit disposal");
    $form = new Admin_Form_CreateDisposal();
    $mdisposal = new Admin_Model_Disposal;
    $disposal = $mdisposal->show($this->_request->getParam('id'));
    $form->provider_id->setValue($disposal['provider_id']);
    $form->description->setValue($disposal['description']);
    $form->disposal_date->setValue($disposal['disposal_date']);
    $this->setSeclectProvider($form);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $disposal_date = $request->getParam('disposal_date');
        $description = $request->getParam('description');
        $provider_id = $request->getParam('provider_id');
        $data = array ('disposal_date' => $disposal_date, 'description' => $description,
          'provider_id'=>$provider_id);
        if($mdisposal->update($disposal['id'], $data)){
          $this->_redirect('/admin/disposal/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function deleteAction(){
    $id=$this->_request->getParam('id');
    $mdisposal=new Admin_Model_Disposal;
    $devices = $this->getDevices($id);
    if($mdisposal->delete($id)){
      $mdetail = new Admin_Model_DeviceDetail;
      foreach($devices as $device){
        $device_detail = $this->getDeviceDetail($device['device_id']);
        $value = explode(".", $device_detail['device_no']);
        if (count($value) > 3)
          $detail_status = array('status_id' => 2);
        else
          $detail_status = array('status_id' => 1);
        $mdetail->update($device_detail['id'], $detail_status);
      }
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/disposal/index');
  }

  public function devicesAction(){
    $this->view->headTitle(" | Disposal's Detail");
    $mdevice = new Admin_Model_DeviceDisposal;
    $this->view->id = $this->_request->getParam('id');
    $paginator = Zend_Paginator::factory($mdevice->index($this->_request->getParam('id')));
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function createdeviceAction(){
    $this->view->headTitle(" | Add device");
    $form = new Admin_Form_AddDeviceDisposal();
    $id = $this->_request->getParam('id');
    $form->disposal_id->setValue($id);
    $mdevice = new Admin_Model_DeviceDisposal;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $cost = $request->getParam('cost');
        $mdetail = new Admin_Model_DeviceDetail;
        $device = $mdetail->getByDeviceNo($request->getParam('device_no'));
        $data = array('device_id' => $device['id'], 'cost' => $cost, 'disposal_id'=>$id);
        if($mdevice->create($data)){
          $detail = array('status_id' => 4);
          $mdetail->update($device['id'], $detail);
          $this->_redirect('/admin/disposal/devices/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editdeviceAction(){
    $this->view->headTitle(" | Edit device");
    $form = new Admin_Form_AddDeviceDisposal();
    $mdevice = new Admin_Model_DeviceDisposal;
    $did = $this->_request->getParam('id');
    $device = $mdevice->show($did);
    $form->device_no->setValue($this->getDeviceDetail($device['device_id'])['device_no']);
    $form->device_no->setAttrib('disabled','disabled');
    $id = $device['disposal_id'];
    $form->cost->setValue($device['cost']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $cost = $request->getParam('cost');
        $data = array('cost' => $cost);
        if($mdevice->update($did, $data)){
          $this->_redirect('/admin/disposal/devices/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function deletedeviceAction(){
    $did=$this->_request->getParam('id');
    $mdevice=new Admin_Model_DeviceDisposal;
    $device = $mdevice->show($did);
    $id=$device['disposal_id'];
    if($mdevice->delete($did)){
      $mdetail = new Admin_Model_DeviceDetail;
      $device_detail = $this->getDeviceDetail($device['device_id']);
      $value = explode(".", $device_detail['device_no']);
      if (count($value) > 3)
        $detail = array('status_id' => 2);
      else
        $detail = array('status_id' => 1);
      $mdetail->update($device_detail['id'], $detail);
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/disposal/devices/id/'.$id);
  }

  private function setSeclectProvider($form){
    $mprovider = new Admin_Model_Provider;
    $provider = array();
    foreach ($mprovider->index() as $b) {
      $provider[$b['id']] = $b['name'];
    }
    $form->provider_id->addMultiOptions($provider);
  }

  public function getProvider($id){
    $mprovider=new Admin_Model_Provider;
    return $mprovider->show($id);
  }

  public function getDevices($id){
    $mdevice=new Admin_Model_DeviceDisposal;
    return $mdevice->index($id);
  }

  public function getIncrease($id){
    $mincrease=new Admin_Model_Increase;
    return $mincrease->show($id);
  }

  public function getIncreaseCost($id){
    $mdevice=new Admin_Model_DeviceDetail;
    return $mdevice->getIncreaseCost($id);
  }

  public function getDevice($id){
    $mdevice=new Admin_Model_Device;
    return $mdevice->show($id);
  }

  public function getDeviceDetail($id){
    $mdevice=new Admin_Model_DeviceDetail;
    return $mdevice->show($id);
  }
}