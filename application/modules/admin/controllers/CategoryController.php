<?php
require_once 'AuthController.php';
class Admin_CategoryController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Categories");        
    $mcategory=new Admin_Model_Category;
    $paginator = Zend_Paginator::factory($mcategory->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create category");
    $form = new Admin_Form_CreateCategory();
    $mcategory = new Admin_Model_Category;
    $this->setSeclect($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $type = $request->getParam('type_id');
        $data = array ('name' => $name, 'description' => $description,'type_id'=>$type);
        if($mcategory->create($data)){
          $this->_redirect('/admin/category/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function showAction(){
    $this->view->headTitle(" | Show category");
    $mcategory = new Admin_Model_Category;    
    $category = $mcategory->show($this->_request->getParam('id'));
    $this->view->category = $category;
    $this->view->controller = $this;
  }

  public function editAction(){
    $this->view->headTitle(" | Edit category");
    $form = new Admin_Form_CreateCategory();
    $mcategory = new Admin_Model_Category;    
    $category = $mcategory->show($this->_request->getParam('id'));
    $form->name->setValue($category['name']);
    $form->description->setValue($category['description']);
    $this->setSeclect($form);
    $form->type_id->setValue($category['type_id']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $type = $request->getParam('type_id');
        $data = array ('name' => $name, 'description' => $description,'type_id'=>$type);
        if($mcategory->update($category['id'], $data)){
          $this->_redirect('/admin/category/index');
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
    $mcategory=new Admin_Model_Category;
    if($mcategory->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/category/index');
  }

  private function setSeclect($form){
    $mtype = new Admin_Model_Type;
    $type = array();
    foreach ($mtype->index() as $b) {
      $type[$b['id']] = $b['name'];
    }
    $form->type_id->addMultiOptions($type);
  }

  public function getType($id){
    $mtype=new Admin_Model_Type;
    return $mtype->show($id);
  }
}