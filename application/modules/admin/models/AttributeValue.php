<?php
class Admin_Model_AttributeValue{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $query = $this->db->select()->from('attribute_value');
    return $this->db->fetchAll($query);
  }

  public function listvalue($id){
    $query = $this->db->select()->from('attribute_value')->where('attribute_id=?',$id);
    return $this->db->fetchAll($query);
  }

  public function create($data){
    $query = $this->db->insert('attribute_value', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('attribute_value')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('attribute_value', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('attribute_value', $data, 'id='.$id);
    return $sql;
  }
}