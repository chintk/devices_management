<?php
class Admin_Model_Provider{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from provider  order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('provider', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('provider')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('provider', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('provider', $data, 'id='.$id);
    return $sql;
  }
}