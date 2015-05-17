<?php
class Admin_Form_DisposalDevice extends Zend_Form{
  public function init(){
    $this->addElement('hidden', 'disposal_id');

    $this->addElement('text','device_no',array('label'=>'Device number', 'class'=>'form-control'));

    $this->addElement('text','cost',array('label'=>'Cost', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Add', 'class'=>'btn btn-primary'));
  }
}