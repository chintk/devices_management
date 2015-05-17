<?php
class Admin_Model_Device
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
        $wheres = [];

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

        $sql=$this->db->query($query);
        return $sql->fetchAll();
    }

    public function getIdsFromList($devices)
    {
        $ids = array();
        foreach ($devices as $device) {
            $ids[] = $device['id'];
        }
        return $ids;

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