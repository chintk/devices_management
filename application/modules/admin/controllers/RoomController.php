<?php
require_once 'AuthController.php';
class Admin_RoomController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Rooms");
    $this->view->controller = $this;
    $mroom=new Admin_Model_Room;
    $paginator = Zend_Paginator::factory($mroom->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function newAction(){
    $this->view->headTitle(" | Create Room");
    $form = new Admin_Form_CreateRoom();
    $mroom = new Admin_Model_Room;
    $this->setSeclect($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        if($request->getParam('building_id')!=0)
          $building_id = $request->getParam('building_id');
        else $building_id = null;
        if($request->getParam('department_id')!=0)
          $department_id = $request->getParam('department_id');
        else $department_id = null;
        if($request->getParam('institute_id')!=0)
          $institute_id = $request->getParam('institute_id');
        else $institute_id = null;
        $data = array ('name' => $name, 'description' => $description,
          'building_id'=>$building_id,'department_id'=>$department_id,'institute_id'=>$institute_id);
        if($mroom->create($data)){
          $this->_redirect('/admin/room/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit room");
    $form = new Admin_Form_CreateRoom();
    $mroom = new Admin_Model_Room;    
    $room = $mroom->show($this->_request->getParam('id'));
    $form->name->setValue($room['name']);
    $form->description->setValue($room['description']);
    $this->setSeclect($form);
    $form->building_id->setValue($room['building_id']);
    $form->institute_id->setValue($room['institute_id']);
    $form->department_id->setValue($room['department_id']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        if($request->getParam('building_id')!=0)
          $building_id = $request->getParam('building_id');
        else $building_id = null;
        if($request->getParam('department_id')!=0)
          $department_id = $request->getParam('department_id');
        else $department_id = null;
        if($request->getParam('institute_id')!=0)
          $institute_id = $request->getParam('institute_id');
        else $institute_id = null;
        $data = array ('name' => $name, 'description' => $description,
          'building_id'=>$building_id,'department_id'=>$department_id,'institute_id'=>$institute_id);
        if($mroom->update($room['id'], $data)){
          $this->_redirect('/admin/room/index');
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
    $mroom=new Admin_Model_Room;
    if($mroom->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/room/index');
  }

  private function setSeclect($form){
    $mbuiding = new Admin_Model_Building;
    $building = array(0=>null);
    foreach ($mbuiding->index() as $b) {
      $building[$b['id']] = $b['name'];
    }
    $form->building_id->addMultiOptions($building);
    $minstitute = new Admin_Model_Institute;
    $institute = array(0=>null);
    foreach ($minstitute->index() as $b) {
      $institute[$b['id']] = $b['name'];
    }
    $form->institute_id->addMultiOptions($institute);
    $mdepartment = new Admin_Model_Department;
    $department = array(0=>null);
    foreach ($mdepartment->listall() as $b) {
      $department[$b['id']] = $b['name'];
    }
    $form->department_id->addMultiOptions($department);
  }

  private function setSeclectDepartment(){
    $id = $this->_request->getParam('id');
    $mdepartment = new Admin_Model_Department;
    $department = array(0=>null);
    foreach ($mdepartment->index($id) as $b) {
      $department[$b['id']] = $b['name'];
    }
    echo $department;
  }

  public function getBuilding($id){
    $mbuilding=new Admin_Model_Building;
    if($id > 0)
      return $mbuilding->show($id);
    else return null;
  }

  public function getInstitute($id){
    $mInstitute=new Admin_Model_Institute;
    if($id > 0)
      return $mInstitute->show($id);
    else return null;
  }

  public function getDepartment($id){
    $mDepartment=new Admin_Model_Department;
    if($id > 0)
      return $mDepartment->show($id);
    else return null;
  }
}