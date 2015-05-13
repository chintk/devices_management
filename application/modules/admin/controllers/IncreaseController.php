<?php
require_once 'AuthController.php';
class Admin_IncreaseController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Increases");        
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
    $this->view->headTitle(" | Create increase");
    $form = new Admin_Form_CreateIncrease();
    $mincrease = new Admin_Model_Increase;
    $form->increase_date_day->setValue(date('d'));
    $form->increase_date_month->setValue(date('m'));
    $form->increase_date_year->setValue(date('y')+2000);
    $this->setSeclectProvider($form);
    $this->setDate($form, 'increase_date');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();        
        $invoice_no = $request->getParam('invoice_no');
        $increase_date = $request->getParam('increase_date_year').'-'.$request
        ->getParam('increase_date_month').'-'.$request->getParam('increase_date_day');
        $funds = $request->getParam('funds'); 
        $provider_id = $request->getParam('provider_id');
        $data = array ('invoice_no' => $invoice_no, 'increase_date' => $increase_date, 'funds' => $funds,
          'provider_id'=>$provider_id);
        if($mincrease->create($data)){
          $this->_redirect('/admin/increase/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit increase");
    $form = new Admin_Form_CreateIncrease();
    $mincrease = new Admin_Model_Increase;    
    $increase = $mincrease->show($this->_request->getParam('id'));    
    $form->provider_id->setValue($increase['provider_id']);
    $form->invoice_no->setValue($increase['invoice_no']);
    $value = explode("-", $increase['increase_date']);
    $form->increase_date_day->setValue($value[2]);
    $form->increase_date_month->setValue($value[1]);
    $form->increase_date_year->setValue($value[0]);
    $form->funds->setValue($increase['funds']);
    $this->setSeclectProvider($form);    
    $this->setDate($form, 'increase_date');
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $invoice_no = $request->getParam('invoice_no');
        $increase_date = $request->getParam('increase_date_year').'-'.$request
        ->getParam('increase_date_month').'-'.$request->getParam('increase_date_day');
        $funds = $request->getParam('funds');
        $provider_id = $request->getParam('provider_id');
        $data = array ('invoice_no' => $invoice_no, 'increase_date' => $increase_date, 'funds' => $funds,
          'provider_id'=>$provider_id);
        if($mincrease->update($increase['id'], $data)){
          $this->_redirect('/admin/increase/index');
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
    $form->production_date_day->setValue(date('d'));
    $form->production_date_month->setValue(date('m'));
    $form->production_date_year->setValue(date('Y'));
    $this->setSeclectDevice($form);
    $this->setDate($form, 'production_date');
    $mdevice = new Admin_Model_DeviceIncrease;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $device_id = $request->getParam('device_id');
        $cost = $request->getParam('cost');
        $production_date = $request->getParam('production_date_year').'-'.$request
        ->getParam('production_date_month').'-'.$request->getParam('production_date_day');
        $quantity = $request->getParam('quantity');
        $guarantee = $request->getParam('guarantee');
        $install_fee = $request->getParam('install_fee');
        $transport_fee = $request->getParam('transport_fee');
        $data = array('device_id' => $device_id, 'transport_fee' => $transport_fee, 
          'install_fee' => $install_fee, 'guarantee' => $guarantee, 'cost' => $cost, 
          'quantity' => $quantity, 'increase_id'=>$id, 'production_date'=>$production_date);
        if($mdevice->create($data)){
          $mdetail = new Admin_Model_DeviceDetail;
          $mdv = new Admin_Model_Device;
          for($i=1; $i< $quantity+1; $i++){            
            $detail = array('device_id' => $device_id, 'status_id' => 1, 'device_no' => $mdv->show($device_id)['sign'].'.'.$id.'.'.$i, 
              'production_date' => $production_date, 'increase_id' => $id);
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
    $value = explode("-", $device['production_date']);
    $form->production_date_day->setValue($value[2]);
    $form->production_date_month->setValue($value[1]);
    $form->production_date_year->setValue($value[0]);
    $form->cost->setValue($device['cost']);
    $form->quantity->setValue($device['quantity']);
    $form->guarantee->setValue($device['guarantee']);
    $form->install_fee->setValue($device['install_fee']);
    $form->transport_fee->setValue($device['transport_fee']);
    $form->create->setLabel('Edit');
    $this->setDate($form, 'production_date');
    $this->setSeclectDevice($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $device_id = $request->getParam('device_id');
        $production_date = $request->getParam('production_date_year').'-'.$request
        ->getParam('production_date_month').'-'.$request->getParam('production_date_day');
        $cost = $request->getParam('cost');
        $quantity = $request->getParam('quantity');
        $guarantee = $request->getParam('guarantee');
        $install_fee = $request->getParam('install_fee');
        $transport_fee = $request->getParam('transport_fee');
        $data = array ('device_id' => $device_id, 'transport_fee' => $transport_fee, 
          'install_fee' => $install_fee, 'guarantee' => $guarantee, 'cost' => $cost, 
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

  private function setDate($form, $element){
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
    if($element == 'production_date'){
      $form->production_date_month->addMultiOptions($month);
      $form->production_date_day->addMultiOptions($day); 
      $form->production_date_year->addMultiOptions($year);
    }
    else{
      $form->increase_date_month->addMultiOptions($month);
      $form->increase_date_day->addMultiOptions($day); 
      $form->increase_date_year->addMultiOptions($year);
    }
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
}