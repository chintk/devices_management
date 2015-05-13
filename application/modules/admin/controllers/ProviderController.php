<?php
require_once 'AuthController.php';
class Admin_ProviderController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Providers");        
    $mprovider = new Admin_Model_Provider;
    $paginator = Zend_Paginator::factory($mprovider->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function showAction(){
    $this->view->headTitle(" | Show provider");
    $mprovider = new Admin_Model_Provider;    
    $provider = $mprovider->show($this->_request->getParam('id'));
    $this->view->provider = $provider; 
  }

  public function newAction(){
    $this->view->headTitle(" | Create Provider");
    $form = new Admin_Form_CreateProvider();
    $mprovider = new Admin_Model_Provider;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $email = $request->getParam('email');
        $description = $request->getParam('description');
        $name = $request->getParam('name');
        $phone = $request->getParam('phone');
        $address = $request->getParam('address');  
        $data = array ( 'email' => $email, 'description' => $description, 
          'name' => $name, 'phone' => $phone, 'address' => $address);
        if($mprovider->create($data)){
          $this->_redirect('/admin/provider/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit Provider");
    $form = new Admin_Form_CreateProvider();
    $mprovider = new Admin_Model_Provider;    
    $provider = $mprovider->show($this->_request->getParam('id'));
    $form->email->setValue($provider['email']);
    $form->name->setValue($provider['name']);
    $form->phone->setValue($provider['phone']);
    $form->address->setValue($provider['address']);
    $form->description->setValue($provider['description']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $email = $request->getParam('email');
        $description = $request->getParam('description');
        $name = $request->getParam('name');
        $phone = $request->getParam('phone');
        $address = $request->getParam('address');  
        $data = array ( 'email' => $email, 'description' => $description, 
          'name' => $name, 'phone' => $phone, 'address' => $address);
        if($mprovider->update($provider['id'], $data)){
          $this->_redirect('/admin/provider/index');
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
    $mprovider=new Admin_Model_Provider;
    if($mprovider->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/provider/index');
  }
}