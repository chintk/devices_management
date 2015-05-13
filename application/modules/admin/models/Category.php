<?php
class Admin_Model_Category{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $query = $this->db->select()->from('category');
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('category', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('category')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('category', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('category', $data, 'id='.$id);
    return $sql;
  }
}