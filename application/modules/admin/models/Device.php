<?php
class Admin_Model_Device extends Admin_Model_AbstractModel
{
     protected $db;

    public function __construct()
    {
        $this->db=Zend_Registry::get('db');
    }

    public function index()
    {
        $sql=$this->db->query("select * from device order by id ASC");
        return $sql->fetchAll();
    }

    public function searchByInformation($attributeId, $attributeValueId)
    {
        $query = 'SELECT * FROM device ';
        $wheres = array();

        if ($attributeId) {
            $wheres[] = "EXISTS (
                SELECT *
                FROM device_attribute
                WHERE device_attribute.device_id = device.id
                AND device_attribute.attribute_id = {$attributeId}) ";
        }

        if ($attributeValueId) {
            $wheres[] = "EXISTS (
                SELECT *
                FROM device_attribute
                WHERE device_attribute.device_id = device.id
                AND device_attribute.value_id = {$attributeValueId}) ";
        }

        if (!empty($wheres)) {
            $query .= 'WHERE ' . implode(' AND ', $wheres);
        }

        $query .= 'ORDER BY id ASC';

        $sql = $this->db->query($query);
        return $sql->fetchAll();
    }

    public function searchByInstituteId($instituteId, $startDate)
    {
        $query = "SELECT
            *,
            (
                SELECT increase_date
                FROM increase
                WHERE increase.id = (
                    SELECT increase_id
                    FROM device_detail
                    WHERE device_detail.device_id = device.id
                    AND device_detail.institute_id = {$instituteId}
                    ORDER BY id
                    LIMIT 1
                )
            ) AS increase_date
            FROM device ";

        $wheres = array();

        if ($instituteId) {
            $wheres[] = "EXISTS (
                SELECT *
                FROM device_detail
                WHERE device_detail.device_id = device.id
                AND device_detail.institute_id = {$instituteId}) ";
        }


        if (!empty($wheres)) {
            $query .= 'WHERE ' . implode(' AND ', $wheres);
        }

        if ($startDate) {
            $query .= "HAVING increase_date >= '{$startDate}' ";
        }

        $query .= "ORDER BY id ASC";

        $sql = $this->db->query($query);
        return $sql->fetchAll();
    }

    public function addExternalData(&$device)
    {
        $mDeviceDetail = new Admin_Model_DeviceDetail();
        $mDeviceIncrease = new Admin_Model_DeviceIncrease();
        $mDeviceStatus = new Admin_Model_DeviceStatus();

        $device['device_details'] = $mDeviceDetail->findAllByDeviceId($device['id']);
        $device['device_increases'] = $mDeviceIncrease->findAllByDeviceId($device['id']);
        $device['device_increase_cost'] = $mDeviceIncrease->findTotalCostByDeviceId($device['id']);
        $device['device_statuses'] = $mDeviceStatus->findAllByDeviceId($device['id']);
    }

    public function create($data)
    {
        $query = $this->db->insert('device', $data);
        return $query;
    }

    public function show($id)
    {
        $query = $this->db->select()->from('device')->where('id=?',$id);
        return $this->db->fetchRow($query);
    }

    public function delete($id)
    {
        $sql = $this->db->delete('device', 'id='.$id);
        return $sql;
    }

    public function update($id, $data)
    {
        $sql = $this->db->update('device', $data, 'id='.$id);
        return $sql;
    }
}