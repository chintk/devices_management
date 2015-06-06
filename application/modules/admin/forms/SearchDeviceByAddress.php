<?php
class Admin_Form_SearchDeviceByAddress extends Zend_Form
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
    $this->addElement('select', 'building', array('label'=>'Tòa nhà', 'class'=>'form-control'));
    $this->addElement('select', 'room', array('label'=>'Phòng', 'class'=>'form-control'));
    $this->addElement('select', 'institute_id', array('label'=>'Khoa / Viện / Trung tâm', 'class'=>'form-control'));
    $this->addElement('select', 'department_id', array('label'=>'Bộ môn', 'class'=>'form-control'));
    $this->addElement('submit', 'search', array('ignore'=>true, 'label'=>'Tìm kiếm', 'class'=>'col-md-offset-8 form-control btn btn-primary'));
    $this->getElement('search')->removeDecorator('label');
    $this->addOptions();
  }

  private function addOptions()
  {
    $this->addBuildingOptions();
    $this->addRoomOptions();
    $this->addInstituteOptions();
    $this->addDepartmentOptions();
  }

  private function addBuildingOptions()
  {
    $mBuilding = new Admin_Model_Building;

    $buildings = array(0=>null);
    foreach ($mBuilding->index() as $building) {
      $buildings[$building['id']] = $building['name'];
    }
    $this->building->addMultiOptions($buildings);
  }

  private function addRoomOptions()
  {
    $mRoom = new Admin_Model_Room;

    $rooms = array(0=>null);
    foreach ($mRoom->index() as $room) {
      $rooms[$room['id']] = $room['name'];
    }
    $this->room->addMultiOptions($rooms);
  }

  private function addInstituteOptions()
  {
    $mInstitute = new Admin_Model_Institute;

    $institutes = array(0=>null);
    foreach ($mInstitute->index() as $institute) {
      $institutes[$institute['id']] = $institute['name'];
    }
    $this->institute_id->addMultiOptions($institutes);
  }

  private function addDepartmentOptions()
  {
    $mDepartment = new Admin_Model_Department;

    $departments = array(0=>null);
    foreach ($mDepartment->index() as $department) {
      $departments[$department['id']] = $department['name'];
    }
    $this->department_id->addMultiOptions($departments);
  }
}
