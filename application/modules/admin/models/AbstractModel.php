<?php

class Admin_Model_AbstractModel
{

  public function getIdsFromList($records, $idField = 'id')
  {
    $ids = array();
    foreach ($records as $record) {
      $ids[] = $record[$idField];
    }
    return $ids;
  }

  public function makeList($records, $indexField = 'id')
  {
    $list = array();
    foreach ($records as $record) {
      $list[$record[$indexField]] = $record;
    }
    return $list;
  }
}
