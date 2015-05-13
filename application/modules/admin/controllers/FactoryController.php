<?php
require_once 'AuthController.php';
class Admin_FactoryController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Factories");        
    $mfactory=new Admin_Model_Factory;
    $paginator = Zend_Paginator::factory($mfactory->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create factory");
    $form = new Admin_Form_CreateFactory();
    $mfactory = new Admin_Model_Factory;
    $this->setSeclect($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $phone = $request->getParam('phone');
        $name = $request->getParam('name');
        $founded = $request->getParam('founded');
        $country_id = $request->getParam('country_id');  
        $data = array ('phone' => $phone, 'name' => $name,
         'founded' => $founded, 'country_id' => $country_id);
        if($mfactory->create($data)){
          $this->_redirect('/admin/factory/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function showAction(){
    $this->view->headTitle(" | Show factory");
    $mfactory = new Admin_Model_Factory;    
    $factory = $mfactory->show($this->_request->getParam('id'));
    $this->view->factory = $factory; 
    $this->view->controller = $this;   
  }

  public function editAction(){
    $this->view->headTitle(" | Edit factory");
    $form = new Admin_Form_CreateFactory();
    $mfactory = new Admin_Model_Factory;    
    $factory = $mfactory->show($this->_request->getParam('id'));
    $form->name->setValue($factory['name']);
    $form->founded->setValue($factory['founded']);
    $form->country_id->setValue($factory['country_id']);  
    $this->setSeclect($form); 
    $form->create->setLabel('Edit'); 
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $phone = $factory['phone'];
        $name = $request->getParam('name');
        $founded = $request->getParam('founded');
        $country_id = $request->getParam('country_id');  
        $data = array ('phone' => $phone, 'name' => $name,
         'founded' => $founded, 'country_id' => $country_id);
        if($mfactory->update($factory['id'], $data)){
          $this->_redirect('/admin/factory/index');
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
    $mfactory=new Admin_Model_Factory;
    if($mfactory->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/factory/index');
  }

  private function setSeclect($form){
    $mcountry = new Admin_Model_Country;
    $country = array();
    foreach ($mcountry->index() as $b) {
      $country[$b['id']] = $b['name'];
    }
    $form->country_id->addMultiOptions($country);
  }

  public function getCountry($id){
    $mcountry=new Admin_Model_Country;
    return $mcountry->show($id);
  }
}