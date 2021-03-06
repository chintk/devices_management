<?php
class Admin_Form_CreateDevice extends Zend_Form{
  public function init(){
    $this->addElement('text','sign',array('label'=>'Sign', 'class'=>'form-control'));
    $sign = $this->getElement('sign');
    $sign->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Ten không được bỏ trống.');

    $this->addElement('text','name',array('label'=>'Name', 'class'=>'form-control'));
    $name = $this->getElement('name');
    $name->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Ten không được bỏ trống.');

    $this->addElement('textarea','description',array('label'=>'Description', 'rows'=>'4', 'class'=>'form-control'));

    $this->addElement('select','category_id',array('label'=>'Category', 'class'=>'form-control'));

    $this->addElement('select','factory_id',array('label'=>'Factory', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}