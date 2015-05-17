<?php

class Admin_Form_InstituteDevice extends Zend_Form
{
    public function init()
    {
        $this->setAction('#');
        $this->setMethod('GET');

        $this->addElement('select', 'instituteId', array('label'=>'Institute', 'class'=>'form-control col-md-4'));
        $this->addElement('text', 'startDate', array('label'=>'Start Date', 'class'=>'form-control col-md-4 datepicker'));
        $this->addElement('submit', 'search', array('label'=>'Search Device', 'class'=>'btn btn-primary'));
        $this->addElement('submit', 'export', array('label'=>'Export', 'class'=>'btn btn-danger'));

        $this->addOptions();
    }

    private function addOptions()
    {
        $this->addInstituteOptions();
    }

    private function addInstituteOptions()
    {
        $mInstitute = new Admin_Model_Institute;

        $institutes = array();
        foreach ($mInstitute->index() as $institute) {
            $institutes[$institute['id']] = $institute['name'];
        }
        $this->instituteId->addMultiOptions($institutes);
    }
}
