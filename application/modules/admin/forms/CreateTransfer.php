<?php
class Admin_Form_CreateTransfer extends Zend_Form{
  public function init(){

    $this->addElement('text','decision',array('label'=>'Decision', 'class'=>'form-control'));

    $this->addElement('text','transfer_date',array('label'=>'Transfer date',
        'class'=>'form-control col-md-4 datepicker'));

    $this->addElement('select','department_from',array('label'=>'From Department', 'class'=>'form-control'));

    $this->addElement('select','department_to',array('label'=>'To Department', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}