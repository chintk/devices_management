<?php
class AuthController extends Zend_Controller_Action{
  public function init(){    
    $this->view->headTitle("BKDMS");
  }    
  
  public function preDispatch(){
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $acl = Zend_Registry::get('acl');
      $role="";
      switch($auth->getIdentity()->level){
        case 1: $role = "admin"; break;
        case 2: $role = "master"; break;
        case 3: $role = "expert"; break;
        case 4: $role = "leader"; break;
        case 5: $role = "staff"; break;
        case 6: $role = "user"; break;
        default : $role = "user";
      }
      $module = $this->_request->getModuleName();
      $controller = $this->_request->getControllerName();
      $action =$this->_request->getActionName();
      $resource=$module.":".$controller;
      if(!$acl->isAllowed($role,$resource,$action)){
        $this->_redirect('/index/error');
      }
      $this->view->user = $auth->getIdentity();     
    }else{
      $this->_redirect('/index/login');
    }
  }
}