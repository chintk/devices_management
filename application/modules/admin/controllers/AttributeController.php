<?php
require_once 'AuthController.php';
class Admin_AttributeController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Attributes");        
    $mattribute=new Admin_Model_Attribute;
    $paginator = Zend_Paginator::factory($mattribute->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create attribute");
    $form = new Admin_Form_CreateAttribute();
    $mattribute = new Admin_Model_Attribute;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $data = array ('name' => $name);
        if($mattribute->create($data)){
          $this->_redirect('/admin/attribute/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit attribute");
    $form = new Admin_Form_CreateAttribute();
    $mattribute = new Admin_Model_Attribute;    
    $attribute = $mattribute->show($this->_request->getParam('id'));
    $form->name->setValue($attribute['name']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $data = array ('name' => $name);
        if($mattribute->update($attribute['id'], $data)){
          $this->_redirect('/admin/attribute/index');
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
    $mattribute=new Admin_Model_Attribute;
    if($mattribute->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/attribute/index');
  }

  public function valuesAction(){
    $this->view->headTitle(" | Attribute's values");        
    $mvalue=new Admin_Model_AttributeValue;
    $id = $this->_request->getParam('id');
    $this->view->id = $id;
    $paginator = Zend_Paginator::factory($mvalue->listvalue($id));
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function createvalueAction(){
    $this->view->headTitle(" | Create Attribute's value");
    $form = new Admin_Form_CreateAttribute();
    $mvalue = new Admin_Model_AttributeValue;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $id = $this->_request->getParam('id');
        $data = array ('name' => $name, 'attribute_id'=>$id);
        if($mvalue->create($data)){
          $this->_redirect('/admin/attribute/values/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editvalueAction(){
    $this->view->headTitle(" | Edit Attribute's value");
    $form = new Admin_Form_CreateAttribute();
    $mvalue = new Admin_Model_AttributeValue;
    $did = $this->_request->getParam('id');
    $value = $mvalue->show($did);
    $form->name->setValue($value['name']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $id = $value['attribute_id'];
        $data = array ('name' => $name, 'attribute_id'=>$id);
        if($mvalue->update($value['id'], $data)){
          $this->_redirect('/admin/attribute/values/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function deletevalueAction(){    
    $did=$this->_request->getParam('id');
    $mvalue=new Admin_Model_AttributeValue;
    $id=$mvalue->show($did)['attribute_id'];
    if($mvalue->delete($did)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/attribute/values/id/'.$id);
  }

  public function getValues($id){
    $mvalue=new Admin_Model_AttributeValue;
    return $mvalue->listvalue($id);
  }
}