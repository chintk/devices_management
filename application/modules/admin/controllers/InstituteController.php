<?php
require_once 'AuthController.php';
class Admin_InstituteController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Institutes");        
    $minstitute=new Admin_Model_Institute;
    $paginator = Zend_Paginator::factory($minstitute->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create institute");
    $form = new Admin_Form_CreateInstitute();
    $minstitute = new Admin_Model_Institute;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $sign = $request->getParam('sign');
        $name = $request->getParam('name');
        $description = $request->getParam('description'); 
        $data = array ('sign' => $sign, 'name' => $name, 'description' => $description);
        if($minstitute->create($data)){
          $this->_redirect('/admin/institute/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit institute");
    $form = new Admin_Form_CreateInstitute();
    $minstitute = new Admin_Model_Institute;    
    $institute = $minstitute->show($this->_request->getParam('id'));
    $form->sign->setValue($institute['sign']);
    $form->name->setValue($institute['name']);
    $form->description->setValue($institute['description']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();        
        $sign = $request->getParam('sign');
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $data = array ('sign' => $sign, 'name' => $name, 'description' => $description);
        if($minstitute->update($institute['id'], $data)){
          $this->_redirect('/admin/institute/index');
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
    $minstitute=new Admin_Model_Institute;
    if($minstitute->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/institute/index');
  }

  public function departmentsAction(){
    $this->view->headTitle(" | Departments");        
    $mdepartment=new Admin_Model_Department;
    $this->view->id = $this->_request->getParam('id');
    $paginator = Zend_Paginator::factory($mdepartment->index($this->_request->getParam('id')));
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function createdepartmentAction(){
    $this->view->headTitle(" | Create department");
    $form = new Admin_Form_CreateInstitute();
    $mdepartment = new Admin_Model_Department;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $sign = $request->getParam('sign');
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $id = $this->_request->getParam('id');
        $data = array ('sign' => $sign, 'name' => $name, 'description' => $description, 'institute_id'=>$id);
        if($mdepartment->create($data)){
          $this->_redirect('/admin/institute/departments/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editdepartmentAction(){
    $this->view->headTitle(" | Edit department");
    $form = new Admin_Form_CreateInstitute();
    $mdepartment = new Admin_Model_Department;
    $did = $this->_request->getParam('id');
    $department = $mdepartment->show($did);
    $form->sign->setValue($department['sign']);
    $form->name->setValue($department['name']);
    $form->description->setValue($department['description']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $sign = $request->getParam('sign');
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $id = $department['institute_id'];
        $data = array ('sign' => $sign, 'name' => $name, 'description' => $description,'institute_id'=>$id);
        if($mdepartment->update($department['id'], $data)){
          $this->_redirect('/admin/institute/departments/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function deletedepartmentAction(){    
    $did=$this->_request->getParam('id');
    $mdepartment=new Admin_Model_Department;
    $id=$mdepartment->show($did)['institute_id'];
    if($mdepartment->delete($did)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/institute/departments/id/'.$id);
  }

  public function getDepartments($id){
    $mdepartment=new Admin_Model_Department;
    return $mdepartment->index($id);
  }
}