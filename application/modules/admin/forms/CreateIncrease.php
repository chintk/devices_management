<?php
class Admin_Form_CreateIncrease extends Zend_Form{
  public function init(){
    $this->addElement('text','invoice_no',array('label'=>'Invoice number', 'class'=>'form-control'));
    $invoice = $this->getElement('invoice_no');
    $invoice->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Ma hoa don không được bỏ trống.');

    $this->addElement('select','increase_date_day',array('label'=>'Increase date',
        'class'=>'form-control'));

    $this->addElement('select','increase_date_month',array('class'=>'form-control'));
    $this->getElement('increase_date_month')->removeDecorator('Label');

    $this->addElement('select','increase_date_year',array('class'=>'form-control'));
    $this->getElement('increase_date_year')->removeDecorator('Label');

    $this->addElement('textarea','funds',array('label'=>'Funds', 'rows'=>'4', 'class'=>'form-control'));

    $this->addElement('select','provider_id',array('label'=>'Provider', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}