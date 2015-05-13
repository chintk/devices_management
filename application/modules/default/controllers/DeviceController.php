<?php
require_once 'AuthController.php';
class DeviceController extends AuthController{
  public function editAction(){
    $this->view->headTitle(" | Setting profile");
    $form = new Form_EditDevice();
    $muser = new Admin_Model_User;    
    $user = $muser->show(Zend_Auth::getInstance()->getIdentity()->id);
    $form->name->setValue($user['name']);
    $form->phone->setValue($user['phone']);
    $this->view->form = $form;
    if($this->_request->getPost('update')){
      if($form->isValid($this->_request->getPost())){        
        $request = $this->getRequest();
        $email = $user['email'];
        $paswd = md5($request->getParam('password'));
        $name = $request->getParam('name');
        $phone = $request->getParam('phone');
        $level = $user['level'];  
        $data = array ( 'email' => $email, 'password' => $paswd, 
          'name' => $name, 'phone' => $phone, 'level' => $level);
        if($muser->update($user['id'], $data)){
          $this->_redirect('user/show');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function showAction(){
    $this->view->headTitle(" | Profile");
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $this->view->user = $auth->getIdentity();     
    }else{
      $this->_redirect('/index/login');
    }    
  }
}