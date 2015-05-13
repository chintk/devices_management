<?php
class Admin_Model_Type{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from type order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('type', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('type')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('type', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('type', $data, 'id='.$id);
    return $sql;
  }
}