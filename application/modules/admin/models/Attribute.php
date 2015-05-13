<?php
class Admin_Model_Attribute{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from attribute where id>1 order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('attribute', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('attribute')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('attribute', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('attribute', $data, 'id='.$id);
    return $sql;
  }
}