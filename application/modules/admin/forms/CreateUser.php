<?php
class Admin_Form_CreateUser extends Zend_Form{
  public function init(){
    $this->addElement('text','email',array('label'=>'Email', 'class'=>'form-control'));
    $email = $this->getElement('email');
    $email->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Email không được bỏ trống.');

    $this->addElement('password','password',array('label'=>'Password', 'class'=>'form-control'));
    $password=$this->getElement('password');
    $password->setRequired(true)->addValidator('NotEmpty')
      ->getValidator('NotEmpty')->setMessage('Password không được bỏ trống');

    $this->addElement('text','name',array('label'=>'name', 'class'=>'form-control'));
    $name = $this->getElement('name');
    $name->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Ten không được bỏ trống.');

    $this->addElement('text','phone',array('label'=>'phone', 'class'=>'form-control'));
    $phone = $this->getElement('phone');
    $phone->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Phone không được bỏ trống.');

    $this->addElement('select','level',array('label'=>'Level', 'value'=>6, 'class'=>'form-control',
      'multiOptions'=>array(1=>'Admin', 2=>'Master', 3=>'Expert', 4=>'Leader', 5=>'Staff', 6=>'User')));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}