<?php
class Admin_Form_CreateIncrease extends Zend_Form{
  public function init(){
    $this->addElement('select','institute_id',array('label'=>'Khoa / Viện / Trung tâm', 'class'=>'form-control'));
    $this->addElement('select','department_id',array('label'=>'Bộ môn', 'class'=>'form-control'));
    $this->addElement('text','invoice_no',array('label'=>'Số hóa đơn', 'class'=>'form-control'));
    $invoice = $this->getElement('invoice_no');
    $invoice->setRequired(true)->addValidator('NotEmpty',true)
      ->getValidator('NotEmpty')->setMessage('Số hóa đơn không được bỏ trống.');

    $this->addElement('text','increase_date',array('label'=>'Ngày nhập',
        'class'=>'form-control col-md-4 datepicker'));

    $this->addElement('textarea','funds',array('label'=>'Nguồn vốn', 'rows'=>'4', 'class'=>'form-control'));

    $this->addElement('select','provider_id',array('label'=>'Nhà cung cấp', 'class'=>'form-control'));

    $this->addElement('submit','create',array('label'=>'Tạo hóa đơn nhập', 'class'=>'btn btn-primary'));
  }
}