<?php

class Admin_Model_DeviceStatus
{
    protected $db;

    public function __construct()
    {
        $this->db=Zend_Registry::get('db');
    }

    public function findAllByDeviceId($deviceId)
    {
        $query = "SELECT *
            FROM device_status
            WHERE EXISTS(
                SELECT *
                FROM device_detail
                WHERE device_detail.status_id = device_status.id
                AND device_detail.device_id = {$deviceId})
        ";
        $sql = $this->db->query($query);
        return $sql->fetchAll();
    }
}