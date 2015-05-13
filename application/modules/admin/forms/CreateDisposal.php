<?php
class Admin_Form_CreateDisposal extends Zend_Form{
  public function init(){
    $this->addElement('select','disposal_date_day',array('label'=>'Disposal date', 
        'class'=>'form-control'));

    $this->addElement('select','disposal_date_month',array('class'=>'form-control'));
    $this->getElement('disposal_date_month')->removeDecorator('Label');

    $this->addElement('select','disposal_date_year',array('class'=>'form-control'));
    $this->getElement('disposal_date_year')->removeDecorator('Label');

    $this->addElement('textarea','description',array('label'=>'Description', 'rows'=>'4', 'class'=>'form-control'));

    $this->addElement('select','provider_id',array('label'=>'Provider', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}