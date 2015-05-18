<?php
class Admin_Form_AddDeviceReuse extends Zend_Form{
  public function init(){
    $this->addElement('text','device_no',array('label'=>'Device sign', 'class'=>'form-control'));

    $this->addElement('text','repair_cost',array('label'=>'Cost', 'class'=>'form-control'));

    $this->addElement('text','reuse_date_day',array('label'=>'Reuse date',
        'class'=>'form-control col-md-4 datepicker'));


    $this->addElement('submit','create',array('label'=>'Add', 'class'=>'btn btn-primary'));
  }
}