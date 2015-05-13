<?php
class Admin_Model_DeviceAttribute{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index($id){
    $query = $this->db->select()->from('device_attribute')->where('device_id=?',$id);
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('device_attribute', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('device_attribute')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('device_attribute', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('device_attribute', $data, 'id='.$id);
    return $sql;
  }
}