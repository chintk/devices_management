<?php
class Admin_Form_SearchDeviceByInformation extends Zend_Form
{
  public function init()
  {
    $this->setAction('#');
    $this->setMethod('GET');

    $this->addElement('select', 'attribute_id', array('label'=>'Attribute', 'class'=>'form-control col-md-4'));
    $this->addElement('select', 'value_id', array('label'=>'Attribute Value', 'class'=>'form-control col-md-4'));
    $this->addElement('submit', 'search', array('label'=>'Search', 'class'=>'btn btn-primary'));

    $this->addOptions();
  }

  private function addOptions()
  {
    $this->addAttributeOptions();
    $this->addAttributeValueOptions();
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
}
