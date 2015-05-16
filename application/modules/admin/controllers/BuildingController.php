<?php
require_once 'AuthController.php';
class Admin_BuildingController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Buildings");
    $mbuilding=new Admin_Model_Building;
    $paginator = Zend_Paginator::factory($mbuilding->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function newAction(){
    $this->view->headTitle(" | Create Building");
    $form = new Admin_Form_CreateLocation();
    $mbuilding = new Admin_Model_Building;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $data = array ('name' => $name, 'description' => $description);
        if($mbuilding->create($data)){
          $this->_redirect('/admin/building/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit building");
    $form = new Admin_Form_CreateLocation();
    $mbuilding = new Admin_Model_Building;
    $building = $mbuilding->show($this->_request->getParam('id'));
    $form->name->setValue($building['name']);
    $form->description->setValue($building['description']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $data = array ('name' => $name, 'description' => $description);
        if($mbuilding->update($building['id'], $data)){
          $this->_redirect('/admin/building/index');
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
    $mbuilding=new Admin_Model_Building;
    if($mbuilding->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/building/index');
  }
}