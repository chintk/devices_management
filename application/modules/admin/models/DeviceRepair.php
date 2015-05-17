<?php
class Admin_Model_DeviceRepair{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index($id){
    $query = $this->db->select()->from('device_reuse')->where('repair_id=?',$id);
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('device_reuse', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('device_reuse')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){

    $sql = $this->db->delete('device_reuse', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('device_reuse', $data, 'id='.$id);
    return $sql;
  }
}