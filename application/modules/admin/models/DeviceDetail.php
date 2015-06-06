<?php
class Admin_Model_DeviceDetail extends Admin_Model_AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db=Zend_Registry::get('db');
    }

    public function index()
    {
        $sql=$this->db->query("select * from device_detail order by id ASC");
        return $sql->fetchAll();
    }

    public function searchByAddress($room, $building, $department, $institute)
    {
      $query = 'SELECT * FROM device_detail ';
      $wheres = array();

      if ($room) {
          $wheres[] = "room_id = {$room} ";
      }

      if ($building) {
          $wheres[] = "EXISTS (
              SELECT *
              FROM room
              WHERE device_detail.room_id = room.id
              AND room.building_id = {$building}) ";
      }

      if ($department) {
          $wheres[] = "EXISTS (
              SELECT *
              FROM department
              WHERE substring(device_detail.device_no, 1, 6) = department.sign
              AND department.id = {$department}) ";
      }

      if ($institute) {
          $wheres[] = "EXISTS (
              SELECT *
              FROM institute
              WHERE substring(device_detail.device_no, 1, 4) = substring(institute.sign, 1, 4)
              AND institute.id = {$institute}) ";
      }

      if (!empty($wheres)) {
          $query .= 'WHERE ' . implode(' AND ', $wheres);
      }

      $query .= 'ORDER BY id ASC';

      $sql = $this->db->query($query);
      return $sql->fetchAll();
  }

    public function findListByDeviceIds($deviceIds)
    {
        if (empty($deviceIds)) {
            return null;
        }

        $query = 'SELECT * FROM device_detail WHERE device_id IN (' . implode(',', $deviceIds) . ')';
        $sql = $this->db->query($query);
        $deviceDetails = $sql->fetchAll();
        return $deviceDetails;
        // return $this->makeList($deviceDetails, 'device_id');
    }

    public function findAllByDeviceId($deviceId)
    {
        $query = 'SELECT * FROM device_detail WHERE device_id = ' . $deviceId;
        $sql = $this->db->query($query);
        return $sql->fetchAll();
    }

    public function create($data)
    {
        $query = $this->db->insert('device_detail', $data);
        return $query;
    }

    public function show($id)
    {
        $query = $this->db->select()->from('device_detail')->where('id=?',$id);
        return $this->db->fetchRow($query);
    }

    public function delete($id)
    {
        $sql = $this->db->delete('device_detail', 'id='.$id);
        return $sql;
    }

    public function update($id, $data)
    {
        $sql = $this->db->update('device_detail', $data, 'id='.$id);
        return $sql;
    }

    public function getDeviceByIncrease($device_id, $increase_id)
    {
        if($device_id == null){
            $sql=$this->db->query("select * from device_detail where increase_id=".$increase_id);
        }
        else{
            $sql=$this->db->query("select * from device_detail where device_id=".$device_id." and increase_id=".$increase_id);
        }
        return $sql->fetchAll();
    }

    public function getIncreaseCost($id)
    {
        $query = $this->db->select()->from('device_detail')->where('id=?',$id);
        $device = $this->db->fetchRow($query);
        $query2 = $this->db->select()->from('device_increase')->where('increase_id=? and device_id=?',$device['increase_id'], $device['device_id']);
        return $this->db->fetchRow($query2);
    }

    public function getStatus($id)
    {
        $query = $this->db->select()->from('device_detail')->where('id=?',$id);
        $device = $this->db->fetchRow($query);
        $query2 = $this->db->select()->from('device_status')->where('id=?',$device['status_id']);
        return $this->db->fetchRow($query2);
    }

    public function getByDeviceNo($device_no)
    {
        $query = $this->db->select()->from('device_detail')->where('device_no=?',$device_no);
        return $this->db->fetchRow($query);
    }

    public function getLast($unit){
      $query = $this->db->select()->from('device_detail')->where('substring(device_no, 1, 6)=?', $unit)->order('id DESC')->limit(1);
      return $this->db->fetchRow($query);
    }

    public function getInfo($id){
      $query = $this->db->select()->from('device_detail')
        ->joinLeft('increase','device_detail.increase_id = increase.id')
        ->joinLeft('provider','provider.id = increase.provider_id')
        ->joinLeft('device_status','device_status.id = device_detail.status_id', array('device_status.name'=>'device_status.name'))
        ->joinLeft('room','room.id = device_detail.room_id', array('room.name'=>'room.name'))
        ->joinLeft('device_increase', 'device_detail.increase_id = device_increase.increase_id AND device_increase.device_id = device_detail.device_id')
        ->where('device_detail.id=?', $id);
      return $this->db->fetchRow($query);
    }
}