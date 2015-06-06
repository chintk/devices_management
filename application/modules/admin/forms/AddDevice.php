<?php
class Admin_Form_AddDevice extends Zend_Form{
  public function init(){
    $this->addElement('hidden', 'increase_id');

    $this->addElement('select','device_id',array('label'=>'Tên thiết bị', 'class'=>'form-control'));

    $this->addElement('text','production_date',array('label'=>'Ngày sản xuất',
        'class'=>'form-control col-md-4 datepicker'));

    $this->addElement('text','quantity',array('label'=>'Số lượng', 'class'=>'form-control'));

    $this->addElement('text','cost',array('label'=>'Giá trị', 'class'=>'form-control'));

    $this->addElement('text','guarantee',array('label'=>'Thời gian bảo hành', 'class'=>'form-control'));

    $this->addElement('text','amortized',array('label'=>'Thời gian khấu hao', 'class'=>'form-control'));

    $this->addElement('text','install_fee',array('label'=>'Phí lắp đặt, vận hành', 'class'=>'form-control'));

    $this->addElement('text','transport_fee',array('label'=>'Phí vận chuyển', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Thêm thiết bị', 'class'=>'btn btn-primary'));
  }
}