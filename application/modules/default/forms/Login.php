<?php
class Form_Login extends Zend_Form{
  public function init(){
    $this->addElement('text','email',array('label'=>'Email', 'class'=>'form-control'));
    $username = $this->getElement('email');
    $username->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Username không được bỏ trống.');
    $this->addElement('password','password',array('label'=>'Password', 'class'=>'form-control'));
    $password=$this->getElement('password');
    $password->setRequired(true)->addValidator('NotEmpty')
      ->getValidator('NotEmpty')->setMessage('Password không được bỏ trống');
    $this->addElement('submit','login',array('label'=>'Login', 'class'=>'btn btn-primary'));
  }
}