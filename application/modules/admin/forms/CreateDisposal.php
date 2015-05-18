<?php
class Admin_Form_CreateDisposal extends Zend_Form{
  public function init(){
    $this->addElement('text','disposal_date',array('label'=>'Disposal date',
        'class'=>'form-control  col-md-4 datepicker'));

    $this->addElement('textarea','description',array('label'=>'Description', 'rows'=>'4', 'class'=>'form-control'));

    $this->addElement('select','provider_id',array('label'=>'Provider', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Create', 'class'=>'btn btn-primary'));
  }
}