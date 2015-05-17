<?php
class Admin_Model_DeviceTransfer{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index($id){
    $query = $this->db->select()->from('device_transfer')->where('transfer_id=?',$id);
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('device_transfer', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('device_transfer')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){

    $sql = $this->db->delete('device_transfer', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('device_transfer', $data, 'id='.$id);
    return $sql;
  }
}