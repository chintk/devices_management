<?php
class Admin_Form_CreateFactory extends Zend_Form{
  public function init(){
    $this->addElement('text','name',array('label'=>'Name', 'class'=>'form-control'));
    $name = $this->getElement('name');
    $name->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Name can not be empty.');

    $this->addElement('select','country_id',array('label'=>'Country', 'class'=>'form-control'));

    $this->addElement('text','phone',array('label'=>'Phone', 'class'=>'form-control'));

    $this->addElement('text','founded',array('label'=>'Founded', 'class'=>'form-control'));    
    
    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}