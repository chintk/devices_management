<?php
class Admin_Model_Country  extends Admin_Model_AbstractModel
{
	protected $db;

	public function __construct()
	{
		$this->db=Zend_Registry::get('db');
	}

	public function index()
	{
		$sql=$this->db->query("select * from country order by id ASC");
		return $sql->fetchAll();
	}

	public function create($data)
	{
		$query = $this->db->insert('country', $data);
		return $query;
	}

	public function show($id)
	{
		$query = $this->db->select()->from('country')->where('id=?',$id);
		return $this->db->fetchRow($query);
	}

	public function delete($id)
	{
		$sql = $this->db->delete('country', 'id='.$id);
		return $sql;
	}

	public function update($id, $data)
	{
		$sql = $this->db->update('country', $data, 'id='.$id);
		return $sql;
	}

	public function getByDeviceId($id)
	{
		$query = $this->db->select()->from('device_detail')->where('id=?',$id);
		$device_detail = $this->db->fetchRow($query);
		$query = $this->db->select()->from('device')->where('id=?',$device_detail['device_id']);
		$device = $this->db->fetchRow($query);
		$query = $this->db->select()->from('factory')->where('id=?',$device['factory_id']);
		$factory = $this->db->fetchRow($query);
		$query = $this->db->select()->from('country')->where('id=?',$factory['country_id']);
		return $this->db->fetchRow($query);
	}
}