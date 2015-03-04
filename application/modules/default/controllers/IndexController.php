<?php
class IndexController extends Zend_Controller_Action{
  public function init(){
    $this->view->headTitle("QHOnline - Zend Layout");    
  }

  public function indexAction(){
  }

  public function loginAction(){
    $mod=$this->_request->getModuleName();
    $formLogin = new Default_Form_Login();
    if($this->_request->getPost('login')){
      if($formLogin->isValid($this->_request->getPost())){  
        $arrayData=$formLogin->getValues();
        //1. Lay ket noi voi database
            $db = Zend_Db_Table::getDefaultAdapter();
            
            //2. 
            $authAdapter = new Zend_Auth_Adapter_DbTable($db);
            $authAdapter->setTableName('user')
                        ->setIdentityColumn('email')
                        ->setCredentialColumn('password');
            
            //3.
                        $request = $this->getRequest();
                        $uname = $request->getParam('email');

                $paswd = $request->getParam('password');

                $authAdapter->setIdentity($uname);
                $authAdapter->setCredential($paswd);
            // $authAdapter->setIdentity($arrData['email']);
            // $password = md5($arrData['password']);
            // $authAdapter->setCredential($arrData['password']);
            
            //4.
            $select = $authAdapter->getDbSelect();
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if($result->isValid()){
           $getInfo = $authAdapter->getResultRowObject(null,array('password'));
           $auth->getStorage()->write($getInfo);
           $this->_redirect('/index/welcome');
        }else{
          $this->_redirect('/index/login');   
        }
      }
    }
    $this->view->formLogin=$formLogin;
  }

  public function welcomeAction(){
    $mod=$this->_request->getModuleName();
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $userInfo = $auth->getIdentity();
      $this->view->username = $userInfo->email;
    }else{
      $this->_redirect('/'.$mod.'/index/login');
    }
  }
}