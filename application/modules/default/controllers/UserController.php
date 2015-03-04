<?php
class UserController extends Zend_Controller_Action{
    public function indexAction(){
        $muser=new Model_User;
        $paginator = Zend_Paginator::factory($muser->listall());
        $paginator->setItemCountPerPage(3);       
        $paginator->setPageRange(3);
        $currentPage = $this->_request->getParam('page',1);
        $paginator->setCurrentPageNumber($currentPage);
        $this->view->data=$paginator;
    }
}