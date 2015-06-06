<?php
class Admin_Model_Institute{
  protected $db;

  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }

  public function index(){
    $sql=$this->db->query("select * from institute order by id ASC");
    return $sql->fetchAll();
  }

  public function create($data){
    $query = $this->db->insert('institute', $data);
    return $query;
  }

  public function show($id){
    $query = $this->db->select()->from('institute')->where('id=?',$id);
    return $this->db->fetchRow($query);
  }

  public function delete($id){
    $sql = $this->db->delete('institute', 'id='.$id);
    return $sql;
  }

  public function update($id, $data){
    $sql = $this->db->update('institute', $data, 'id='.$id);
    return $sql;
  }

  public function getBySign($sign){
    $query = $this->db->select()->from('institute')->where('sign=?',$sign);
    return $this->db->fetchRow($query);
  }
}