<?php
require_once 'AuthController.php';
class Admin_TypeController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Types");
    $mtype=new Admin_Model_Type;
    $paginator = Zend_Paginator::factory($mtype->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function newAction(){
    $this->view->headTitle(" | Create Type");
    $form = new Admin_Form_CreateLocation();
    $mtype = new Admin_Model_Type;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $data = array ('name' => $name, 'description' => $description);
        if($mtype->create($data)){
          $this->_redirect('/admin/type/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit type");
    $form = new Admin_Form_CreateLocation();
    $mtype = new Admin_Model_Type;
    $type = $mtype->show($this->_request->getParam('id'));
    $form->name->setValue($type['name']);
    $form->description->setValue($type['description']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $data = array ('name' => $name, 'description' => $description);
        if($mtype->update($type['id'], $data)){
          $this->_redirect('/admin/type/index');
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
    $mtype=new Admin_Model_Type;
    if($mtype->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/type/index');
  }
}