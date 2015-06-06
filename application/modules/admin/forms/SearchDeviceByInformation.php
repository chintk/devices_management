<?php
class Admin_Form_SearchDeviceByInformation extends Zend_Form
{
  public function init()
  {
    $this->setAction('#');
    $this->setMethod('GET');
    $this->setElementDecorators(array(
        'viewHelper',
        'Errors',
        array('Label'),
        array(
            array('row'=>'HtmlTag'),
            array('tag'=>'div', 'class'=>'form-group'),        
        ),
        array('HtmlTag', array('tag'=>'div', 'class'=>'col-md-4 col-md-offset-1')),
    ));
    $this->addElement('select', 'attribute_id', array('label'=>'Thuộc tính thiết bị', 'class'=>'form-control'));
    $this->addElement('select', 'value_id', array('label'=>'Giá trị thuộc tính', 'class'=>'form-control'));
    $this->addElement('select', 'type', array('label'=>'Loại thiết bị', 'class'=>'form-control'));
    $this->addElement('select', 'name', array('label'=>'Tên thiết bị', 'class'=>'form-control'));
    $this->addElement('select', 'country', array('label'=>'Nước sản xuất', 'class'=>'form-control'));
    $this->addElement('select', 'factory', array('label'=>'Nhà sản xuất', 'class'=>'form-control'));
    $this->addElement('text', 'cost_min', array('label'=>'Giá trị thiết bị thấp nhất', 'class'=>'form-control'));
    $this->addElement('text', 'cost_max', array('label'=>'Giá trị thiết bị cao nhất', 'class'=>'form-control'));
    $this->addElement('submit', 'search', array('ignore'=>true, 'label'=>'Tìm kiếm', 'class'=>'col-md-offset-8 form-control btn btn-primary'));
    $this->getElement('search')->removeDecorator('label');
    $this->addOptions();
  }

  private function addOptions()
  {
    $this->addAttributeOptions();
    $this->addAttributeValueOptions();
    $this->addTypeOptions();
    $this->addNameOptions();
    $this->addCountryOptions();
    $this->addFactoryOptions();
  }

  private function addAttributeOptions()
  {
    $mAttribute = new Admin_Model_Attribute;

    $attributes = array(0=>null);
    foreach ($mAttribute->index() as $attribute) {
      $attributes[$attribute['id']] = $attribute['name'];
    }
    $this->attribute_id->addMultiOptions($attributes);
  }

  private function addAttributeValueOptions()
  {
    $mAttribute = new Admin_Model_AttributeValue;

    $attribute_values = array(0=>null);
    foreach ($mAttribute->index() as $attribute_value) {
      $attribute_values[$attribute_value['id']] = $attribute_value['name'];
    }
    $this->value_id->addMultiOptions($attribute_values);
  }

  private function addTypeOptions()
  {
    $mType = new Admin_Model_Type;

    $types = array(0=>null);
    foreach ($mType->index() as $type) {
      $types[$type['id']] = $type['name'];
    }
    $this->type->addMultiOptions($types);
  }

  private function addNameOptions()
  {
    $mDevice = new Admin_Model_Device;

    $devices = array(0=>null);
    foreach ($mDevice->index() as $device) {
      $devices[$device['id']] = $device['name'];
    }
    $this->name->addMultiOptions($devices);
  }

  private function addFactoryOptions()
  {
    $mFactory = new Admin_Model_Factory;

    $factories = array(0=>null);
    foreach ($mFactory->index() as $factory) {
      $factories[$factory['id']] = $factory['name'];
    }
    $this->factory->addMultiOptions($factories);
  }

  private function addCountryOptions()
  {
    $mCountry = new Admin_Model_Country;

    $countries = array(0=>null);
    foreach ($mCountry->index() as $country) {
      $countries[$country['id']] = $country['name'];
    }
    $this->country->addMultiOptions($countries);
  }
}
