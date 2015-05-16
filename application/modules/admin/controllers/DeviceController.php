<?php
require_once 'AuthController.php';
class Admin_DeviceController extends Admin_AuthController{
  public function indexAction(){
    $this->view->headTitle(" | Devices");
    $mdevice=new Admin_Model_Device;
    $paginator = Zend_Paginator::factory($mdevice->index());
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function newAction(){
    $this->view->headTitle(" | Create device");
    $form = new Admin_Form_CreateDevice();
    $mdevice = new Admin_Model_Device;
    $this->setSeclect($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $sign = $request->getParam('sign');
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $category_id = $request->getParam('category_id');
        $factory_id = $request->getParam('factory_id');
        $data = array ('sign' => $sign, 'name' => $name, 'description' => $description,
          'category_id'=>$category_id, 'factory_id'=>$factory_id);
        if($mdevice->create($data)){
          $this->_redirect('/admin/device/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editAction(){
    $this->view->headTitle(" | Edit device");
    $form = new Admin_Form_CreateDevice();
    $mdevice = new Admin_Model_Device;
    $device = $mdevice->show($this->_request->getParam('id'));
    $form->sign->setValue($device['sign']);
    $form->name->setValue($device['name']);
    $form->description->setValue($device['description']);
    $this->setSeclect($form);
    $form->factory_id->setValue($device['factory_id']);
    $form->category_id->setValue($device['category_id']);
    $form->create->setLabel('Edit');
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $sign = $request->getParam('sign');
        $name = $request->getParam('name');
        $description = $request->getParam('description');
        $category_id = $request->getParam('category_id');
        $factory_id = $request->getParam('factory_id');
        $data = array ('sign' => $sign, 'name' => $name, 'description' => $description,
          'category_id'=>$category_id, 'factory_id'=>$factory_id);
        if($mdevice->update($device['id'], $data)){
          $this->_redirect('/admin/device/index');
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function deleteAction(){
    $id=$this->_request->getParam('id');
    $mdevice=new Admin_Model_Device;
    if($mdevice->delete($id)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/device/index');
  }

  public function attributesAction(){
    $this->view->headTitle(" | Device's Attributes");
    $mattribute=new Admin_Model_DeviceAttribute;
    $this->view->id = $this->_request->getParam('id');
    $paginator = Zend_Paginator::factory($mattribute->index($this->_request->getParam('id')));
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(10);
    $currentPage = $this->_request->getParam('page',1);
    $paginator->setCurrentPageNumber($currentPage);
    $this->view->data=$paginator;
    $this->view->controller = $this;
  }

  public function createattributeAction(){
    $this->view->headTitle(" | Add attribute");
    $form = new Admin_Form_AddAttribute();
    $id = $this->_request->getParam('id');
    $form->device_id->setValue($id);
    $this->setSeclectValue($form);
    $mattribute = new Admin_Model_DeviceAttribute;
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $attribute_id = $request->getParam('attribute_id');
        $value_id = $request->getParam('value_id');
        $data = array ('attribute_id' => $attribute_id, 'value' => null, 'value_id' => $value_id, 'device_id'=>$id);
        if($mattribute->create($data)){
          $this->_redirect('/admin/device/attributes/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function editattributeAction(){
    $this->view->headTitle(" | Edit attribute");
    $form = new Admin_Form_AddAttribute();
    $mattribute = new Admin_Model_DeviceAttribute;
    $did = $this->_request->getParam('did');
    $attribute = $mattribute->show($did);
    $form->attribute_id->setValue($attribute['attribute_id']);
    $form->value_id->setValue($attribute['value_id']);
    $form->create->setLabel('Edit');
    $this->setSeclectValue($form);
    $this->view->form = $form;
    if($this->_request->getPost('create')){
      if($form->isValid($this->_request->getPost())){
        $request = $this->getRequest();
        $attribute_id = $request->getParam('attribute_id');
        $id = $attribute['device_id'];
        $value_id = $request->getParam('value_id');
        $data = array ('attribute_id' => $attribute_id, 'value' => null, 'value_id' => $value_id,'device_id'=>$id);
        if($mattribute->update($attribute['id'], $data)){
          $this->_redirect('/admin/device/attributes/id/'.$id);
        }
        else{
          echo "error";
          $this->getHelper('ViewRenderer')->setNoRender();
        }
      }
    }
  }

  public function deleteattributeAction(){
    $did=$this->_request->getParam('did');
    $mattribute=new Admin_Model_DeviceAttribute;
    $id=$mattribute->show($did)['device_id'];
    if($mattribute->delete($did)){
      echo "Complete";
    }
    else{
      echo "error";
    }
    $this->getHelper('viewRenderer')->setNoRender();
    $this->_redirect('/admin/device/attributes/id/'.$id);
  }

  private function setSeclect($form){
    $mcategory = new Admin_Model_Category;
    $category = array();
    foreach ($mcategory->index() as $b) {
      $category[$b['id']] = $b['name'];
    }
    $form->category_id->addMultiOptions($category);
    $mfactory = new Admin_Model_Factory;
    $factory = array();
    foreach ($mfactory->index() as $b) {
      $factory[$b['id']] = $b['name'];
    }
    $form->factory_id->addMultiOptions($factory);
  }

  public function setSeclectValue($form){
    $mattribute = new Admin_Model_Attribute;
    $attribute = array();
    foreach ($mattribute->index() as $b) {
      $attribute[$b['id']] = $b['name'];
    }
    $form->attribute_id->addMultiOptions($attribute);
    $mvalue = new Admin_Model_AttributeValue;
    $value = array();
    foreach ($mvalue->index() as $b) {
      $value[$b['id']] = $b['name'];
    }
    $form->value_id->addMultiOptions($value);
  }

  public function getCategory($id){
    $mcategory=new Admin_Model_Category;
    return $mcategory->show($id);
  }

  public function getFactory($id){
    $mfactory=new Admin_Model_Factory;
    return $mfactory->show($id);
  }

  public function getAttributes($id){
    $mattribute=new Admin_Model_DeviceAttribute;
    return $mattribute->index($id);
  }

  public function getAttribute($id){
    $mattribute=new Admin_Model_Attribute;
    return $mattribute->show($id);
  }

  public function getValue($id){
    $mvalue = new Admin_Model_AttributeValue;
    return $mvalue->show($id);
  }
}