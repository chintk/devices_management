<?php
class Model_User{
  protected $db;
  public function __construct(){
    $this->db=Zend_Registry::get('db');
  }
  public function listall(){
    $sql=$this->db->query("select * from user order by id DESC");
    return $sql->fetchAll();
  }
}