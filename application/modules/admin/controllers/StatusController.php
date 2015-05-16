<?php
require_once 'AuthController.php';
class Admin_StatusController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Status");
    $mstatus=new Admin_Model_Status;
    $paginator = Zend_Paginator::factory($mstatus->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create status");
    $form = new Admin_Form_CreateAttribute();
    $mstatus = new Admin_Model_Status;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $data = array ('name' => $name);
        if($mstatus->create($data)){
          $this->_redirect('/admin/status/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit status");
    $form = new Admin_Form_CreateAttribute();
    $mstatus = new Admin_Model_Status;
    $status = $mstatus->show($this->_request->getParam('id'));
    $form->name->setValue($status['name']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $data = array ('name' => $name);
        if($mstatus->update($status['id'], $data)){
          $this->_redirect('/admin/status/index');
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
    $mstatus=new Admin_Model_Status;
    if($mstatus->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/status/index');
  }
}