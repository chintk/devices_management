<?php
class Admin_Model_Repair{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from repair order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('repair', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('repair')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('repair', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('repair', $data, 'id='.$id);
    return $sql;
  }
}