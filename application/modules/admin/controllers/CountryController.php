<?php
require_once 'AuthController.php';
class Admin_CountryController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Countries");        
    $mcountry=new Admin_Model_Country;
    $paginator = Zend_Paginator::factory($mcountry->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function newAction(){
    $this->view->headTitle(" | Create Country");
    $form = new Admin_Form_CreateCountry();
    $mcountry = new Admin_Model_Country;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $code = $request->getParam('code'); 
        $data = array ('name' => $name, 'code' => $code);
        if($mcountry->create($data)){
          $this->_redirect('/admin/country/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit country");
    $form = new Admin_Form_CreateCountry();
    $mcountry = new Admin_Model_Country;    
    $country = $mcountry->show($this->_request->getParam('id'));
    $form->name->setValue($country['name']);
    $form->code->setValue($country['code']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $code = $request->getParam('code');
        $data = array ('name' => $name, 'code' => $code);
        if($mcountry->update($country['id'], $data)){
          $this->_redirect('/admin/country/index');
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
    $mcountry=new Admin_Model_Country;
    if($mcountry->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/country/index');
  }
}