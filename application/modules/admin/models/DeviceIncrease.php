<?php
class Admin_Model_DeviceIncrease extends Admin_Model_AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db=Zend_Registry::get('db');
    }

    public function index($id)
    {
        $query = $this->db->select()->from('device_increase')->where('increase_id=?',$id);
        return $this->db->fetchAll($query);
    }

    public function findTotalCostByDeviceId($deviceId)
    {
        $query = "SELECT
            SUM('cost') AS sum_cost,
            SUM('install_fee') AS sum_install_fee,
            SUM(transport_fee) AS sum_transport_fee
            FROM device_increase
            WHERE device_id = {$deviceId}";

        $sql = $this->db->query($query);
        return $sql->fetch();
    }

    public function findAllByDeviceId($deviceId)
    {
        $query = 'SELECT
            *,
            (SELECT increase.increase_date FROM increase WHERE increase.id = device_increase.increase_id) AS increase_date,
            (SELECT increase.funds FROM increase WHERE increase.id = device_increase.increase_id) AS increase_funds
            FROM device_increase
            WHERE device_id = ' . $deviceId;
        $sql = $this->db->query($query);
        return $sql->fetchAll();
    }

    public function create($data)
    {
        $query = $this->db->insert('device_increase', $data);
        return $query;
    }

    public function show($id)
    {
        $query = $this->db->select()->from('device_increase')->where('id=?',$id);
        return $this->db->fetchRow($query);
    }

    public function delete($id)
    {

        $sql = $this->db->delete('device_increase', 'id='.$id);
        return $sql;
    }

    public function update($id, $data)
    {
        $sql = $this->db->update('device_increase', $data, 'id='.$id);
        return $sql;
    }
}
