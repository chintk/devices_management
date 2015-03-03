<?php
class Model_User extends Zend_Db_Table_Abstract{
  protected $_name="user";
  protected $_primary="id";
  public function listall(){
    return $this->fetchall()->toArray();
  }
}