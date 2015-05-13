<?php
class Admin_Model_Department{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function listall(){
    $query = $this->db->select()->from('department');
    return $this->db->fetchAll($query);
  }

  public function index($id){
    $query = $this->db->select()->from('department')->where('institute_id=?',$id);
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('department', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('department')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('department', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('department', $data, 'id='.$id);
    return $sql;
  }
}