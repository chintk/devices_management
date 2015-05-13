<?php
class Admin_Model_Increase{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from increase order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('increase', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('increase')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('increase', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('increase', $data, 'id='.$id);
    return $sql;
  }
}