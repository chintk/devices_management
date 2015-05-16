<?php
class Admin_Form_AddDevice extends Zend_Form{
  public function init(){
    $this->addElement('hidden', 'increase_id');

    $this->addElement('select','device_id',array('label'=>'Device', 'class'=>'form-control'));

    $this->addElement('select','production_date_day',array('label'=>'Production date',
        'class'=>'form-control'));

    $this->addElement('select','production_date_month',array('class'=>'form-control'));
    $this->getElement('production_date_month')->removeDecorator('Label');

    $this->addElement('select','production_date_year',array('class'=>'form-control'));
    $this->getElement('production_date_year')->removeDecorator('Label');

    $this->addElement('text','quantity',array('label'=>'Quantity', 'class'=>'form-control'));

    $this->addElement('text','cost',array('label'=>'Cost', 'class'=>'form-control'));

    $this->addElement('text','guarantee',array('label'=>'Guarantee', 'class'=>'form-control'));

    $this->addElement('text','install_fee',array('label'=>'Install fee', 'class'=>'form-control'));

    $this->addElement('text','transport_fee',array('label'=>'Transport fee', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Add', 'class'=>'btn btn-primary'));
  }
}