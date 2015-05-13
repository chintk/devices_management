<?php
class Admin_Model_Device{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from device order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('device', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('device')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('device', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('device', $data, 'id='.$id);
    return $sql;
  }
}