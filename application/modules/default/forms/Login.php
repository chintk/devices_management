<?php
class Default_Form_Login extends Zend_Form{
  public function init(){   
    $this->addElement('text','email',array('label'=>'Email', 'size'=>21));
    $username = $this->getElement('email');
    $username->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Username không được bỏ trống.');
    $this->addElement('password','password',array('label'=>'Password', 'size'=>21));
    $password=$this->getElement('password');
    $password->setRequired(true)->addValidator('NotEmpty')
      ->getValidator('NotEmpty')->setMessage('Password không được bỏ trống');
    $this->addElement('submit','login',array('label'=>'Login'));
  }
}