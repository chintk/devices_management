<?php
class Admin_Form_AddAttribute extends Zend_Form{
  public function init(){
    $this->addElement('hidden', 'device_id');

    $this->addElement('select','attribute_id',array('label'=>'Attribute', 'class'=>'form-control'));

    $this->addElement('select','value_id',array('label'=>'Value', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}