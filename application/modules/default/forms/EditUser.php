<?php
class Form_EditUser extends Zend_Form{
  public function init(){
    $this->addElement('text','name',array('label'=>'Name', 'class'=>'form-control'));
    $name = $this->getElement('name');
    $name->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Name can not be empty.');

    $this->addElement('text','phone',array('label'=>'Phone', 'class'=>'form-control'));
    $phone = $this->getElement('phone');
    $phone->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('phone can not be empty.');

    $this->addElement('password','password',array('label'=>'Confirm password', 'class'=>'form-control'));
    $password=$this->getElement('password');
    $password->setRequired(true)->addValidator('NotEmpty')
      ->getValidator('NotEmpty')->setMessage('Password to confirm');
    
    $this->addElement('submit','update',array('label'=>'Update', 'class'=>'btn btn-primary'));
  }
}