<?php
class Form_Login extends Zend_Form{
  public function init(){
    $this->addElement('text','email',array('label'=>'Tên tài khoản', 'class'=>'form-control'));
    $username = $this->getElement('email');
    $username->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Tên tài khoản không được bỏ trống.');
    $this->addElement('password','password',array('label'=>'Mật khẩu', 'class'=>'form-control'));
    $password=$this->getElement('password');
    $password->setRequired(true)->addValidator('NotEmpty')
      ->getValidator('NotEmpty')->setMessage('Mật khẩu không được bỏ trống');
    $this->addElement('submit','login',array('label'=>'Đăng nhập', 'class'=>'col-md-12 btn btn-primary'));
  }
}