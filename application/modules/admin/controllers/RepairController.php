<?php
require_once 'AuthController.php';
class Admin_RepairController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Repairs");
    $mrepair=new Admin_Model_Repair;
    $paginator = Zend_Paginator::factory($mrepair->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create repair");
    $form = new Admin_Form_CreateDisposal();
    $mrepair = new Admin_Model_Repair;
    $form->disposal_date_day->setValue(date('d'));
    $form->disposal_date_month->setValue(date('m'));
    $form->disposal_date_year->setValue(date('Y'));
    $form->disposal_date_day->setLabel('Repair date');
    $this->setSeclectProvider($form);
    $this->setDateRepair($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $repair_date = $request->getParam('disposal_date_year').'-'.$request
        ->getParam('disposal_date_month').'-'.$request->getParam('disposal_date_day');
        $description = $request->getParam('description');
        $provider_id = $request->getParam('provider_id');
        $data = array ('repair_date' => $repair_date, 'description' => $description,
          'provider_id'=>$provider_id);
        if($mrepair->create($data)){
          $this->_redirect('/admin/repair/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit repair");
    $form = new Admin_Form_CreateDisposal();
    $mrepair = new Admin_Model_Repair;
    $repair = $mrepair->show($this->_request->getParam('id'));
    $form->provider_id->setValue($repair['provider_id']);
    $form->description->setValue($repair['description']);
    $value = explode("-", $repair['repair_date']);
    $form->disposal_date_day->setValue($value[2]);
    $form->disposal_date_day->setLabel('Repair date');
    $form->disposal_date_month->setValue($value[1]);
    $form->disposal_date_year->setValue($value[0]);
    $this->setSeclectProvider($form);
    $this->setDateRepair($form);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $repair_date = $request->getParam('disposal_date_year').'-'.$request
        ->getParam('disposal_date_month').'-'.$request->getParam('disposal_date_day');
        $description = $request->getParam('description');
        $provider_id = $request->getParam('provider_id');
        $data = array ('repair_date' => $repair_date, 'description' => $description,
          'provider_id'=>$provider_id);
        if($mrepair->update($repair['id'], $data)){
          $this->_redirect('/admin/repair/index');
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
    $mrepair=new Admin_Model_Repair;
    $devices = $this->getDevices($id);
    if($mrepair->delete($id)){
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
    $this->_redirect('/admin/repair/index');
  }

  public function devicesAction(){
    $this->view->headTitle(" | Repair's Detail");
    $mdevice = new Admin_Model_DeviceRepair;
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
    $form = new Admin_Form_AddDeviceTransfer();
    $id = $this->_request->getParam('id');
    $form->transfer_id->setValue($id);
    $mdevice = new Admin_Model_DeviceRepair;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $mdetail = new Admin_Model_DeviceDetail;
        $device = $mdetail->getByDeviceNo($request->getParam('device_no'));
        $data = array('device_id' => $device['id'], 'repair_id'=>$id);
        if($mdevice->create($data)){
          $detail = array('status_id' => 3);
          $mdetail->update($device['id'], $detail);
          $this->_redirect('/admin/repair/devices/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function reuseAction(){
    $this->view->headTitle(" | Reuse device");
    $form = new Admin_Form_AddDeviceReuse();
    $mdevice = new Admin_Model_DeviceRepair;
    $did = $this->_request->getParam('id');
    $device = $mdevice->show($did);
    $form->device_no->setValue($this->getDeviceDetail($device['device_id'])['device_no']);
    $form->device_no->setAttrib('disabled','disabled');
    $id = $device['repair_id'];
    $form->create->setLabel('Reuse');
    $form->reuse_date_day->setValue(date('d'));
    $form->reuse_date_month->setValue(date('m'));
    $form->reuse_date_year->setValue(date('Y'));
    $this->setDateReuse($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $cost = $request->getParam('repair_cost');
        $reuse_date = $request->getParam('reuse_date_year').'-'.$request
        ->getParam('reuse_date_month').'-'.$request->getParam('reuse_date_day');
        $data = array('repair_cost' => $cost, 'reuse_date'=>$reuse_date);
        if($mdevice->update($did, $data)){
          $mdetail = new Admin_Model_DeviceDetail;
          $detail = array('status_id' => 2);
          $mdetail->update($device['id'], $detail);
          $this->_redirect('/admin/repair/devices/id/'.$id);
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
    $mdevice=new Admin_Model_DeviceRepair;
    $device = $mdevice->show($did);
    $id=$device['repair_id'];
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
    $this->_redirect('/admin/repair/devices/id/'.$id);
  }

  private function setSeclectProvider($form){
    $mprovider = new Admin_Model_Provider;
    $provider = array();
    foreach ($mprovider->index() as $b) {
      $provider[$b['id']] = $b['name'];
    }
    $form->provider_id->addMultiOptions($provider);
  }

  private function setDateReuse($form){
    $day = array();
    for($i=1; $i<32; $i++) {
      $day[$i] = $i;
    }
    $month = array();
    for($i=1; $i<13; $i++) {
      $month[$i] = date('F', strtotime($i.'/1/1990'));
    }
    $year = array();
    for($i=date('Y')-20; $i<date('Y')+20; $i++) {
      $year[$i] = $i;
    }
    $form->reuse_date_month->addMultiOptions($month);
    $form->reuse_date_day->addMultiOptions($day);
    $form->reuse_date_year->addMultiOptions($year);
  }

  private function setDateRepair($form){
    $day = array();
    for($i=1; $i<32; $i++) {
      $day[$i] = $i;
    }
    $month = array();
    for($i=1; $i<13; $i++) {
      $month[$i] = date('F', strtotime($i.'/1/1990'));
    }
    $year = array();
    for($i=date('Y')-20; $i<date('Y')+20; $i++) {
      $year[$i] = $i;
    }
    $form->disposal_date_month->addMultiOptions($month);
    $form->disposal_date_day->addMultiOptions($day);
    $form->disposal_date_year->addMultiOptions($year);
  }

  public function getProvider($id){
    $mprovider=new Admin_Model_Provider;
    return $mprovider->show($id);
  }

  public function getDevices($id){
    $mdevice=new Admin_Model_DeviceRepair;
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