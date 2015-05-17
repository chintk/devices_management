<?php
class Admin_Form_CreateTransfer extends Zend_Form{
  public function init(){

    $this->addElement('text','decision',array('label'=>'Decision', 'class'=>'form-control'));

    $this->addElement('select','transfer_date_day',array('label'=>'Transfer date',
        'class'=>'form-control'));

    $this->addElement('select','transfer_date_month',array('class'=>'form-control'));
    $this->getElement('transfer_date_month')->removeDecorator('Label');

    $this->addElement('select','transfer_date_year',array('class'=>'form-control'));
    $this->getElement('transfer_date_year')->removeDecorator('Label');

    $this->addElement('select','department_from',array('label'=>'From Department', 'class'=>'form-control'));

    $this->addElement('select','department_to',array('label'=>'To Department', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}