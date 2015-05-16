<?php
class Admin_Model_DeviceDisposal{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index($id){
    $query = $this->db->select()->from('device_disposal')->where('disposal_id=?',$id);
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('device_disposal', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('device_disposal')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){

    $sql = $this->db->delete('device_disposal', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('device_disposal', $data, 'id='.$id);
    return $sql;
  }
}