<?php
class Admin_Model_Status{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from device_status");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('device_status', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('device_status')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('device_status', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('device_status', $data, 'id='.$id);
    return $sql;
  }
}