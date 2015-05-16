<?php
class Admin_Form_CreateProvider extends Zend_Form{
  public function init(){
    $this->addElement('text','name',array('label'=>'Name', 'class'=>'form-control'));
    $name = $this->getElement('name');
    $name->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Ten không được bỏ trống.');

    $this->addElement('text','description',array('label'=>'Description', 'class'=>'form-control'));

    $this->addElement('text','phone',array('label'=>'Phone', 'class'=>'form-control'));

    $this->addElement('text','email',array('label'=>'Email', 'class'=>'form-control'));

    $this->addElement('text','address',array('label'=>'Address', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}