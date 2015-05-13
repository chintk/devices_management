<?php
class Admin_Form_CreateRoom extends Zend_Form{
  public function init(){
    $this->addElement('text','name',array('label'=>'Name', 'class'=>'form-control'));
    $name = $this->getElement('name');
    $name->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Ten không được bỏ trống.');

    $this->addElement('textarea','description',array('label'=>'Description', 'rows'=>'4', 'class'=>'form-control'));

    $this->addElement('select','building_id',array('label'=>'Building', 'class'=>'form-control'));
    
    $this->addElement('select','institute_id',array('label'=>'Institute', 'class'=>'form-control'));

    $this->addElement('select','department_id',array('label'=>'Department', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}