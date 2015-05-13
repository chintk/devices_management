<?php
require_once 'AuthController.php';
class Admin_UserController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Users");        
    $muser=new Admin_Model_User;
    $paginator = Zend_Paginator::factory($muser->index());
    $paginator->setItemCountPerPage(10);       
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
  }

  public function newAction(){
    $this->view->headTitle(" | Create user");
    $form = new Admin_Form_CreateUser();
    $muser = new Admin_Model_User;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $email = $request->getParam('email');
        $paswd = md5($request->getParam('password'));
        $name = $request->getParam('name');
        $phone = $request->getParam('phone');
        $level = $request->getParam('level');  
        $data = array ( 'email' => $email, 'password' => $paswd, 
          'name' => $name, 'phone' => $phone, 'level' => $level);
        if($muser->create($data)){
          $this->_redirect('/admin/user/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit user");
    $form = new Admin_Form_EditUser();
    $muser = new Admin_Model_User;    
    $user = $muser->show($this->_request->getParam('id'));
    $form->name->setValue($user['name']);
    $form->phone->setValue($user['phone']);
    $form->level->setValue($user['level']);
    $this->view->form = $form;
    if($this->_request->getPost('update')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $email = $user['email'];
        $paswd = md5($request->getParam('password'));
        $name = $request->getParam('name');
        $phone = $request->getParam('phone');
        $level = $request->getParam('level');  
        $data = array ( 'email' => $email, 'password' => $paswd, 
          'name' => $name, 'phone' => $phone, 'level' => $level);
        if($muser->update($user['id'], $data)){
          $this->_redirect('/admin/user/index');
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
    $muser=new Admin_Model_User;
    if($muser->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }    
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/user/index');
  }
}