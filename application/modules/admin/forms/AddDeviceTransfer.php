<?php
class Admin_Form_AddDeviceTransfer extends Zend_Form{
  public function init(){
    $this->addElement('hidden', 'transfer_id');

    $this->addElement('text','device_no',array('label'=>'Device sign', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Add', 'class'=>'btn btn-primary'));
  }
}