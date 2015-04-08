<?php
class IndexController extends Zend_Controller_Action{
  public function init(){    
    $this->view->headTitle("BKDMS");
  } 

  public function errorAction(){
    echo "You don't have permission to access this action";
    $this->getHelper('ViewRenderer')->setNoRender();
  }

  public function indexAction(){
  }

  public function loginAction(){
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      if($getInfo->level == 1)
        $this->_redirect('/admin/index/index');
      else
        $this->_redirect('user/show');
    }else{
      $this->view->headTitle(" | Login");
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
            if($getInfo->level == 1)
              $this->_redirect('/admin/index/index');
            else
              $this->_redirect('user/show');
          }else{
            $this->_redirect('/index/login');   
          }
        }
      }
    }
  }

  public function logoutAction(){
    $storage = new Zend_Auth_Storage_Session();
    $storage->clear();
    $this->_redirect('/'); 
  }
}