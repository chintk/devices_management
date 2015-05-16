<?php
require_once 'AuthController.php';
class Admin_TransferController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Transfers");
    $mtransfer=new Admin_Model_Transfer;
    $paginator = Zend_Paginator::factory($mtransfer->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newtransferAction(){
    $this->view->headTitle(" | Create transfer");
    $form = new Admin_Form_CreateTransfer();
    $mtransfer = new Admin_Model_Transfer;
    $form->transfer_date_day->setValue(date('d'));
    $form->transfer_date_month->setValue(date('m'));
    $form->transfer_date_year->setValue(date('Y'));
    $kind = $this->_request->getParam('kind');
    $this->setSeclectTransfer($form, $kind);
    $this->setDate($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $transfer_date = $request->getParam('transfer_date_year').'-'.$request
        ->getParam('transfer_date_month').'-'.$request->getParam('transfer_date_day');
        $decision = $request->getParam('decision');
        if($kind=="department"){
          $department_from = $request->getParam('department_from');
          $department_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'department_to'=>$department_to, 'department_from'=>$department_from);
        }elseif($kind=="institute"){
          $institute_from = $request->getParam('department_from');
          $institute_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'institute_to'=>$institute_to, 'institute_from'=>$institute_from);
        }elseif ($kind=="room") {
          $room_from = $request->getParam('department_from');
          $room_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'room_to'=>$room_to, 'room_from'=>$room_from);
        }
        if($mtransfer->create($data)){
          $this->_redirect('/admin/transfer/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function newdistributionAction(){
    $this->view->headTitle(" | Create distribution");
    $form = new Admin_Form_CreateDistribution();
    $mtransfer = new Admin_Model_Transfer;
    $form->transfer_date_day->setValue(date('d'));
    $form->transfer_date_month->setValue(date('m'));
    $form->transfer_date_year->setValue(date('Y'));
    $kind = $this->_request->getParam('kind');
    $this->setSeclectDistribution($form, $kind);
    $this->setDate($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $transfer_date = $request->getParam('transfer_date_year').'-'.$request
        ->getParam('transfer_date_month').'-'.$request->getParam('transfer_date_day');
        $decision = $request->getParam('decision');
        if($kind=="department"){
          $department_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'department_to'=>$department_to);
        }elseif($kind=="institute"){
          $institute_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'institute_to'=>$institute_to);
        }elseif ($kind=="room") {
          $room_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'room_to'=>$room_to);
        }
        if($mtransfer->create($data)){
          $this->_redirect('/admin/transfer/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function edittransferAction(){
    $this->view->headTitle(" | Edit transfer");
    $form = new Admin_Form_CreateTransfer();
    $mtransfer = new Admin_Model_Transfer;
    $transfer = $mtransfer->show($this->_request->getParam('id'));
    if($transfer['department_from']!=null){
      $kind="department";
      $form->department_to->setValue($transfer['department_to']);
      $form->department_from->setValue($transfer['department_from']);
    }elseif ($transfer['institute_from']!=null) {
      $kind="institute";
      $form->department_to->setValue($transfer['institute_to']);
      $form->department_from->setValue($transfer['institute_from']);
    }elseif ($transfer['room_from']!=null) {
      $kind="room";
      $form->department_to->setValue($transfer['room_to']);
      $form->department_from->setValue($transfer['room_from']);
    }
    $form->decision->setValue($transfer['decision']);
    $value = explode("-", $transfer['transfer_date']);
    $form->transfer_date_day->setValue($value[2]);
    $form->transfer_date_month->setValue($value[1]);
    $form->transfer_date_year->setValue($value[0]);
    $this->setSeclectTransfer($form, $kind);
    $this->setDate($form);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $transfer_date = $request->getParam('transfer_date_year').'-'.$request
        ->getParam('transfer_date_month').'-'.$request->getParam('transfer_date_day');
        $decision = $request->getParam('decision');
        if($kind=="department"){
          $department_from = $request->getParam('department_from');
          $department_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'department_to'=>$department_to, 'department_from'=>$department_from);
        }elseif($kind=="institute"){
          $institute_from = $request->getParam('department_from');
          $institute_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'institute_to'=>$institute_to, 'institute_from'=>$institute_from);
        }elseif ($kind=="room") {
          $room_from = $request->getParam('department_from');
          $room_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'room_to'=>$room_to, 'room_from'=>$room_from);
        }
        if($mtransfer->update($transfer['id'], $data)){
          $this->_redirect('/admin/transfer/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editdistributionAction(){
    $this->view->headTitle(" | Edit distribution");
    $form = new Admin_Form_CreateDistribution();
    $mtransfer = new Admin_Model_Transfer;
    $transfer = $mtransfer->show($this->_request->getParam('id'));
    if($transfer['department_to']!=null){
      $kind="department";
      $form->department_to->setValue($transfer['department_to']);
    }elseif ($transfer['institute_to']!=null) {
      $kind="institute";
      $form->department_to->setValue($transfer['institute_to']);
    }elseif ($transfer['room_to']!=null) {
      $kind="room";
      $form->department_to->setValue($transfer['room_to']);
    }
    $form->decision->setValue($transfer['decision']);
    $value = explode("-", $transfer['transfer_date']);
    $form->transfer_date_day->setValue($value[2]);
    $form->transfer_date_month->setValue($value[1]);
    $form->transfer_date_year->setValue($value[0]);
    $this->setSeclectDistribution($form, $kind);
    $this->setDate($form);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $transfer_date = $request->getParam('transfer_date_year').'-'.$request
        ->getParam('transfer_date_month').'-'.$request->getParam('transfer_date_day');
        $decision = $request->getParam('decision');
        if($kind=="department"){
          $department_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'department_to'=>$department_to);
        }elseif($kind=="institute"){
          $institute_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'institute_to'=>$institute_to);
        }elseif ($kind=="room") {
          $room_to = $request->getParam('department_to');
          $data = array ('transfer_date' => $transfer_date, 'decision' => $decision,
            'room_to'=>$room_to);
        }
        if($mtransfer->update($transfer['id'], $data)){
          $this->_redirect('/admin/transfer/index');
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
    $mtransfer=new Admin_Model_Transfer;
    $transfer = $mtransfer->show($id);
    $devices = $this->getDevices($id);
    $mdetail = new Admin_Model_DeviceDetail;
    $department = $transfer['department_from'];
    $institute = $transfer['institute_from'];
    $room = $transfer['room_from'];
    if($mtransfer->delete($id)){
      foreach($devices as $device){
        $device_detail = $this->getDeviceDetail($device['device_id']);
        $device_no = $device_detail['device_no'];
        $value = explode(".", $device_no);
        $status = 2;
        $use_date = $device_detail['use_date'];
        if($department==null && $institute==null && $room==null){
          $status = 1;
          unset($value[0]);
          $use_date = null;
        }elseif($department!=null){
          $value[0] = "D".$department;
        }elseif($institute!=null){
          $value[0] = "I".$institute;
        }else{
          $value[0] = "R".$room;
        }
        $detail = array('device_no'=>implode('.', $value), 'department_id'=>$department,
          'institute_id'=>$institute, 'room_id'=>$room, 'status_id'=>$status, 'use_date'=>$use_date);
        $mdetail = new Admin_Model_DeviceDetail;
        $mdetail->update($device_detail['id'], $detail);
      }
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/transfer/index');
  }

  public function devicestransferAction(){
    $this->view->headTitle(" | Transfer's Detail");
    $mdevice = new Admin_Model_DeviceTransfer;
    $this->view->id = $this->_request->getParam('id');
    $paginator = Zend_Paginator::factory($mdevice->index($this->_request->getParam('id')));
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function devicesdistributionAction(){
    $this->view->headTitle(" | Distribution's Detail");
    $mdevice = new Admin_Model_DeviceTransfer;
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
    $mdevice = new Admin_Model_DeviceTransfer;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $device_no = $request->getParam('device_no');
        $mdetail = new Admin_Model_DeviceDetail;
        $device = $mdetail->getByDeviceNo($device_no);
        $data = array('device_id' => $device['id'], 'transfer_id'=>$id);
        if($mdevice->create($data)){
          $value = explode(".", $device_no);
          $mtransfer = new Admin_Model_Transfer;
          $transfer = $mtransfer->show($id);
          if(count($value)==3){
            $kind = "distribution";
            $use_date = $transfer['transfer_date'];
          }else{
            $use_date = $device['use_date'];
            $kind = "transfer";
          }
          $department = $transfer['department_to'];
          $institute = $transfer['institute_to'];
          $room = $transfer['room_to'];
          if($department!=null){
            if(count($value)==3)
              array_unshift($value, "D".$transfer['department_to']);
            if(count($value)==5)
              unset($value[0]);
            $value[0] = "D".$transfer['department_to'];
          }elseif($institute!=null){
            if(count($value)==3)
              array_unshift($value, "I".$transfer['institute_to']);
            if(count($value)==5)
              unset($value[0]);
            $value[0] = "I".$transfer['institute_to'];
          }elseif($room!=null){
            if(count($value)==3)
              array_unshift($value, "R".$transfer['room_to']);
            else
              $value[0] = "R".$transfer['room_to'];
          }
          $device_no = implode(".", $value);
          $detail = array('status_id' => 2, 'device_no'=>$device_no, 'department_id'=>$department,
            'institute_id'=>$institute, 'room_id'=>$room, 'use_date'=>$use_date);
          $mdetail->update($device['id'], $detail);
          $this->_redirect('/admin/transfer/devices'.$kind.'/id/'.$id);
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
    $mdevice=new Admin_Model_DeviceTransfer;
    $device = $mdevice->show($did);
    $id=$device['transfer_id'];
    if($mdevice->delete($did)){
      $mtransfer = new Admin_Model_Transfer;
      $transfer = $mtransfer->show($id);
      $device_detail = $this->getDeviceDetail($device['device_id']);
      $device_no = $device_detail['device_no'];
      $value = explode(".", $device_no);
      $department = $transfer['department_from'];
      $institute = $transfer['institute_from'];
      $room = $transfer['room_from'];
      $status = 2;
      $use_date = $device_detail['use_date'];
      if($department==null && $institute==null && $room==null){
        $status = 1;
        unset($value[0]);
        $use_date = null;
      }elseif($department!=null){
        $value[0] = "D".$department;
      }elseif($institute!=null){
        $value[0] = "I".$institute;
      }else{
        $value[0] = "R".$room;
      }
      $detail = array('device_no'=>implode('.', $value), 'department_id'=>$department,
        'institute_id'=>$institute, 'room_id'=>$room, 'status_id'=>$status, 'use_date'=>$use_date);
      $mdetail = new Admin_Model_DeviceDetail;
      $mdetail->update($device_detail['id'], $detail);
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/transfer/devices/id/'.$id);
  }

  private function setSeclectTransfer($form, $kind){
    if($kind == "department"){
      $mdepartment = new Admin_Model_Department;
      $department = array();
      foreach ($mdepartment->listall() as $b) {
        $department[$b['id']] = $b['name'];
      }
      $form->department_to->addMultiOptions($department);
      $form->department_from->addMultiOptions($department);
    }elseif($kind == "institute"){
      $minstitute = new Admin_Model_Institute;
      $institute = array();
      foreach ($minstitute->index() as $b) {
        $institute[$b['id']] = $b['name'];
      }
      $form->department_to->setLabel('To Institute');
      $form->department_from->setLabel('From Institute');
      $form->department_to->addMultiOptions($institute);
      $form->department_from->addMultiOptions($institute);
    }elseif($kind == "room"){
      $mroom = new Admin_Model_Room;
      $room = array();
      foreach ($mroom->index() as $b) {
        $room[$b['id']] = $b['name'];
      }
      $form->department_to->setLabel('To Room');
      $form->department_from->setLabel('From Room');
      $form->department_to->addMultiOptions($room);
      $form->department_from->addMultiOptions($room);
    }
  }

  private function setSeclectDistribution($form, $kind){
    if($kind == "department"){
      $mdepartment = new Admin_Model_Department;
      $department = array();
      foreach ($mdepartment->listall() as $b) {
        $department[$b['id']] = $b['name'];
      }
      $form->department_to->addMultiOptions($department);
    }elseif($kind == "institute"){
      $minstitute = new Admin_Model_Institute;
      $institute = array();
      foreach ($minstitute->index() as $b) {
        $institute[$b['id']] = $b['name'];
      }
      $form->department_to->setLabel('To Institute');
      $form->department_to->addMultiOptions($institute);
    }elseif($kind=="room"){
      $mroom = new Admin_Model_Room;
      $room = array();
      foreach ($mroom->index() as $b) {
        $room[$b['id']] = $b['name'];
      }
      $form->department_to->setLabel('To Room');
      $form->department_to->addMultiOptions($room);
    }
  }

  private function setDate($form){
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
    $form->transfer_date_month->addMultiOptions($month);
    $form->transfer_date_day->addMultiOptions($day);
    $form->transfer_date_year->addMultiOptions($year);
  }

  public function getDepartment($id){
    $mdepartment=new Admin_Model_Department;
    return $mdepartment->show($id);
  }

  public function getInstitute($id){
    $minstitute=new Admin_Model_Institute;
    return $minstitute->show($id);
  }

  public function getRoom($id){
    $mroom=new Admin_Model_Room;
    return $mroom->show($id);
  }

  public function getDevices($id){
    $mdevice=new Admin_Model_DeviceTransfer;
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

  public function getCountry($id){
    $mcountry=new Admin_Model_Country;
    return $mcountry->getByDeviceId($id);
  }

  public function getDeviceDetail($id){
    $mdevice=new Admin_Model_DeviceDetail;
    return $mdevice->show($id);
  }

  public function getStatus($id){
    $mdevice=new Admin_Model_DeviceDetail;
    return $mdevice->getStatus($id);
  }

  public function getDeviceOld($id, $transfer_id){
    $mdevice=new Admin_Model_DeviceDetail;
    $device_no = $mdevice->show($id)['device_no'];
    $value = explode(".", $device_no);
    $mtransfer = new Admin_Model_Transfer;
    $transfer = $mtransfer->show($transfer_id);
    if($transfer['department_from']!=null){
      if(count($value)==4){
        $value[0] = "D".$transfer['department_from'];
      }else{
        $value[1] = "D".$transfer['department_from'];
      }
    }elseif($transfer['institute_from']!=null){
      if(count($value)==4){
        $value[0] = "I".$transfer['institute_from'];
      }else{
        $value[1] = "I".$transfer['institute_from'];
      }
    }elseif($transfer['room_from']!=null){
      $value[0] = "R".$transfer['room_from'];
    }else{
      unset($value[0]);
    }
    return implode(".", $value);
  }
}