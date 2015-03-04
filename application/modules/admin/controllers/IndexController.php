<?php
class Admin_IndexController extends Zend_Controller_Action{
  public function init(){
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $acl = new Zend_Acl();
      $infoUserData = $auth->getIdentity();
      $level = $infoUserData->type;
      $role="";
      switch($level){
        case 1: $role = "admin"; break;
        case 2: $role = "member"; break;
        default : $role = "member";
      }
      $acl->addRole(new Zend_Acl_Role('member'))
          ->addRole(new Zend_Acl_Role('admin'));
      $acl->addResource(new Zend_Acl_Resource('admin:index'));      
      $acl->addResource(new Zend_Acl_Resource('default:index'));
      $acl->allow('member','default:index','index');
      $acl->allow('admin','admin:index',null);
      $acl->allow(null,'admin:index','error');
      $module = $this->_request->getModuleName();
      $controller = $this->_request->getControllerName();
      $action =$this->_request->getActionName();
      $resource=$module.":".$controller;
      if(!$acl->isAllowed($role,$resource,$action)){
        $this->_redirect('/admin/index/error');
      }
    }
  }

  public function indexAction(){
    echo "Module Admin -  Controller Index -  Action Index";
    $this->getHelper('ViewRenderer')->setNoRender();
  }     

  public function preDispatch(){
    $auth = Zend_Auth::getInstance();
    if( !$auth->hasIdentity()){
      $this->_redirect('/index/login');
    }
  }
  public function errorAction(){
    echo "You don't have permission to access this action";
    $this->getHelper('ViewRenderer')->setNoRender();
  }
}