<?php
require_once 'AuthController.php';
class Admin_IncreaseController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Nhập mới thiết bị");
    $mincrease=new Admin_Model_Increase;
    $paginator = Zend_Paginator::factory($mincrease->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Tạo hóa đơn nhập");
    $form = new Admin_Form_CreateIncrease();
    $mincrease = new Admin_Model_Increase;
    $form->increase_date->setValue(date('Y-m-d'));
    $this->setSeclectInstitute($form);
    $this->setSeclectProvider($form);
    $this->setSeclectDepartment($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        if($request->getParam('department_id')!=0){
          $mdepartment = new Admin_Model_Department;
          $unit = $mdepartment->show($request->getParam('department_id'))['sign'];
        }
        else if($request->getParam('institute_id')!=0){
          $mInstitute = new Admin_Model_Institute;
          $unit = $mInstitute->show($request->getParam('institute_id'))['sign'];
        }else $unit = '000000';
        $invoice_no = $request->getParam('invoice_no');
        $increase_date = $request->getParam('increase_date');
        $funds = $request->getParam('funds');
        $provider_id = $request->getParam('provider_id');
        $data = array ('invoice_no' => $invoice_no, 'increase_date' => $increase_date, 'funds' => $funds,
          'provider_id'=>$provider_id, 'unit' => $unit);
        if($mincrease->create($data)){
          $this->_redirect('/admin/increase/index');
        }
        else{
          echo "Đã có lỗi xảy ra, vui lòng kiểm tra lại thông tin";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Thay đổi hóa đơn nhập");
    $mdetail = new Admin_Model_DeviceDetail;
    $details = $mdetail->getDeviceByIncrease(null, $this->_request->getParam('id'));
    if(count($details) == 0){
      $form = new Admin_Form_CreateIncrease();
      $mincrease = new Admin_Model_Increase;
      $increase = $mincrease->show($this->_request->getParam('id'));
      $form->provider_id->setValue($increase['provider_id']);
      $form->invoice_no->setValue($increase['invoice_no']);
      $form->increase_date->setValue($increase['increase_date']);
      $form->funds->setValue($increase['funds']);
      $old_unit = $increase['unit'];
      if($old_unit!='000000'){
        $mInstitute = new Admin_Model_Institute;
        $form->institute_id->setValue($mInstitute->getBySign(substr($old_unit,0,4).'00')['id']);
        if(substr($old_unit,4) != '00'){
          $mDepartment = new Admin_Model_Department;
          $form->department_id->setValue($mDepartment->getBySign($old_unit)['id']);
        }
      }
      $this->setSeclectInstitute($form);
      $this->setSeclectProvider($form);
      $this->setSeclectDepartment($form);
      $form->create->setLabel('Cập nhật');
      $this->view->form = $form;
      if($this->_request->getPost('create')){
        if($form->isValid($this->_request->getPost())){
          $request = $this->getRequest();
          if($request->getParam('department_id')!=0){
            $mdepartment = new Admin_Model_Department;
            $unit = $mdepartment->show($request->getParam('department_id'))['sign'];
          }
          else if($request->getParam('institute_id')!=0){
            $mInstitute = new Admin_Model_Institute;
            $unit = $mInstitute->show($request->getParam('institute_id'))['sign'];
          }else{
            $unit = '000000';
          }
          $invoice_no = $request->getParam('invoice_no');
          $increase_date = $request->getParam('increase_date');
          $funds = $request->getParam('funds');
          $provider_id = $request->getParam('provider_id');
          $data = array ('invoice_no' => $invoice_no, 'increase_date' => $increase_date, 'funds' => $funds,
            'provider_id'=>$provider_id, 'unit' => $unit);
          if($mincrease->update($increase['id'], $data)){
            $this->_redirect('/admin/increase/index');
          }
          else{
            echo "Đã có lỗi xảy ra, vui lòng kiểm tra lại thông tin";
            $this->getHelper('ViewRenderer')->setNoRender();
          }
        }
      }
    }else{
      echo "Hóa đơn không thể thay đổi";
      $this->getHelper('ViewRenderer')->setNoRender();
    }
  }

  public function deleteAction(){
    $id=$this->_request->getParam('id');
    $mincrease=new Admin_Model_Increase;
    if($mincrease->delete($id)){
      $mdetail = new Admin_Model_DeviceDetail;
      $details = $mdetail->getDeviceByIncrease(null, $id);
      foreach($details as $detail){
        $mdetail->delete($detail['id']);
      }
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/increase/index');
  }

  public function devicesAction(){
    $this->view->headTitle(" | Increase's Detail");
    $mdevice = new Admin_Model_DeviceIncrease;
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
    $form = new Admin_Form_AddDevice();
    $id = $this->_request->getParam('id');
    $form->increase_id->setValue($id);
    $form->production_date->setValue(date('Y-m-d'));
    $this->setSeclectDevice($form);
    $mdevice = new Admin_Model_DeviceIncrease;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $device_id = $request->getParam('device_id');
        $cost = $request->getParam('cost');
        $amortized = $request->getParam('amortized');
        $production_date = $request->getParam('production_date');
        $quantity = $request->getParam('quantity');
        $guarantee = $request->getParam('guarantee');
        $install_fee = $request->getParam('install_fee');
        $transport_fee = $request->getParam('transport_fee');
        $data = array('device_id' => $device_id, 'transport_fee' => $transport_fee,
          'install_fee' => $install_fee, 'guarantee' => $guarantee, 'cost' => $cost,
          'quantity' => $quantity, 'increase_id'=>$id, 'production_date'=>$production_date);
        if($mdevice->create($data)){
          $mdetail = new Admin_Model_DeviceDetail;
          $mincrease = new Admin_Model_Increase;
          $unit = $mincrease->show($id)['unit'];
          $no = (int)substr($mdetail->getLast($unit)['device_no'], 6);
          if($unit=='000000'){
            $status = 1;
            $use_date = null;
          }
          else{
            $status = 2;
            $use_date = $production_date;
          }
          for($i=1; $i< $quantity+1; $i++){
            $detail = array('device_id' => $device_id, 'status_id' => $status, 'device_no' => $unit.sprintf("%'.04d",$no+$i),
              'production_date' => $production_date, 'increase_id' => $id, 'use_date' => $use_date);
            $mdetail->create($detail);
          }
          $this->_redirect('/admin/increase/devices/id/'.$id);
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
    $form = new Admin_Form_AddDevice();
    $mdevice = new Admin_Model_DeviceIncrease;
    $did = $this->_request->getParam('id');
    $device = $mdevice->show($did);
    $form->device_id->setValue($device['device_id']);
    $id = $device['increase_id'];
    $form->production_date->setValue($device['production_date']);
    $form->cost->setValue($device['cost']);
    $form->amortized->setValue($device['amortized']);
    $form->quantity->setValue($device['quantity']);
    $form->guarantee->setValue($device['guarantee']);
    $form->install_fee->setValue($device['install_fee']);
    $form->transport_fee->setValue($device['transport_fee']);
    $form->create->setLabel('Cập nhật');
    $this->setSeclectDevice($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $device_id = $request->getParam('device_id');
        $production_date = $request->getParam('production_date');
        $cost = $request->getParam('cost');
        $amortized = $request->getParam('amortized');
        $quantity = $request->getParam('quantity');
        $guarantee = $request->getParam('guarantee');
        $install_fee = $request->getParam('install_fee');
        $transport_fee = $request->getParam('transport_fee');
        $data = array ('device_id' => $device_id, 'transport_fee' => $transport_fee,
          'install_fee' => $install_fee, 'guarantee' => $guarantee, 'cost' => $cost, 'amortized' => $amortized,
          'quantity' => $quantity, 'increase_id'=>$id, 'production_date' => $production_date);
        if($mdevice->update($did, $data)){
          if($device_id != $device['device_id'] || $production_date != $device['production_date'] || $quantity != $device['quantity']){
            $mdetail = new Admin_Model_DeviceDetail;
            $mdv = new Admin_Model_Device;
            $details = $mdetail->getDeviceByIncrease($device['device_id'], $id);
            foreach($details as $detail){
              $mdetail->delete($detail['id']);
            }
            for($i=1; $i< $quantity+1; $i++){
              $detail = array('device_id' => $device_id, 'status_id' => 1, 'device_no' => $mdv->show($device_id)['sign'].'.'.$id.'.'.$i,
                'production_date' => $production_date, 'increase_id' => $id);
              $mdetail->create($detail);
            }
          }
          $this->_redirect('/admin/increase/devices/id/'.$id);
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
    $mdevice=new Admin_Model_DeviceIncrease;
    $device = $mdevice->show($did);
    $id=$device['increase_id'];
    if($mdevice->delete($did)){
      $mdetail = new Admin_Model_DeviceDetail;
      $details = $mdetail->getDeviceByIncrease($device['device_id'], $id);
      foreach($details as $detail){
        $mdetail->delete($detail['id']);
      }
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/increase/devices/id/'.$id);
  }

  private function setSeclectProvider($form){
    $mprovider = new Admin_Model_Provider;
    $provider = array();
    foreach ($mprovider->index() as $b) {
      $provider[$b['id']] = $b['name'];
    }
    $form->provider_id->addMultiOptions($provider);
  }

  private function setSeclectDepartment($form){
    $mDepartment = new Admin_Model_Department;
    $departments = array(0=>null);
    foreach ($mDepartment->index() as $b) {
      $departments[$b['id']] = $b['name'];
    }
    $form->department_id->addMultiOptions($departments);
  }

  private function setSeclectInstitute($form){
    $mInstitute = new Admin_Model_Institute;
    $institutes = array(0=>null);
    foreach ($mInstitute->index() as $b) {
      $institutes[$b['id']] = $b['name'];
    }
    $form->institute_id->addMultiOptions($institutes);
  }

  public function setSeclectDevice($form){
    $mdevice = new Admin_Model_Device;
    $device = array();
    foreach ($mdevice->index() as $b) {
      $device[$b['id']] = $b['name'];
    }
    $form->device_id->addMultiOptions($device);
  }

  public function getProvider($id){
    $mprovider=new Admin_Model_Provider;
    return $mprovider->show($id);
  }

  public function getDevices($id){
    $mdevice=new Admin_Model_DeviceIncrease;
    return $mdevice->index($id);
  }

  public function getDevice($id){
    $mdevice=new Admin_Model_Device;
    return $mdevice->show($id);
  }

  public function getUnit($unit){
    if(substr($unit, 4)== '00'){
      $mInstitute = new Admin_Model_Institute;
      return $mInstitute->getBySign($unit);
    }
    else{
      $mDepartment = new Admin_Model_Department;
      return $mDepartment->getBySign($unit);
    }
  }
}