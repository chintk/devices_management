<?php
class IndexController extends Zend_Controller_Action{
  public function init(){
    $this->view->headTitle("BKDMS"); 
  }

  public function preDispatch(){ 
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      switch($auth->getIdentity()->type){
        case 1: $role = "admin"; break;
        case 2: $role = "master"; break;
        case 3: $role = "expert"; break;
        case 4: $role = "leader"; break;
        case 5: $role = "staff"; break;
        case 6: $role = "user"; break;
        default : $role = "user";
      }
      $acl = Zend_Registry::get('acl');
      $module = $this->_request->getModuleName();
      $controller = $this->_request->getControllerName();
      $action =$this->_request->getActionName();
      $resource=$module.":".$controller;
      if(!$acl->isAllowed($role,$resource,$action)){
        $this->_redirect('/index/error');
      }
      $this->view->user = $auth->getIdentity();
    }
  }

  public function errorAction(){
    echo "You don't have permission to access this action";
    $this->getHelper('ViewRenderer')->setNoRender();
  }

  public function indexAction(){
  }

  public function loginAction(){
    $this->view->headTitle(" | Login");  
    $mod=$this->_request->getModuleName();
    $formLogin = new Form_Login();
    $this->view->formLogin = $formLogin;
    if($this->_request->getPost('login')){
      if($formLogin->isValid($this->_request->getPost())){
        $db = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName('user')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password');
        $request = $this->getRequest();
        $uname = $request->getParam('email');
        $paswd = $request->getParam('password');
        $authAdapter->setIdentity($uname);
        $authAdapter->setCredential(md5($paswd));
        $select = $authAdapter->getDbSelect();
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if($result->isValid()){
          $getInfo = $authAdapter->getResultRowObject();
          $auth->getStorage()->write($getInfo);
          if($getInfo->type == 1)
            $this->_redirect('/admin/index/index');
          else
            $this->_redirect('/');
        }else{
          $this->_redirect('/index/login');   
        }
      }
    }
  }

  public function logoutAction(){
    $storage = new Zend_Auth_Storage_Session();
    $storage->clear();
    $this->_redirect('/'); 
  }

  public function welcomeAction(){
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $userInfo = $auth->getIdentity();
      $this->view->username = $userInfo->email;
      $this->view->baseurl = $this->_request->getbaseurl();      
    }else{
      $this->_redirect('/index/login');
    }
  }
}