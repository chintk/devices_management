<?php
class IndexController extends Zend_Controller_Action{
  public function init(){
    $this->view->headTitle("QHOnline - Zend Layout")
  }
  public function indexAction(){
    echo "<h1>Welcome to Zend Framework - QHOnline.Info";
  } 
}