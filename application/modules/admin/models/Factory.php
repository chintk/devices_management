<?php
class Admin_Model_Factory{
	protected $db;

	public function __construct(){
		$this->db=Zend_Registry::get('db');
	}

	public function index(){
		$sql=$this->db->query("select * from factory  order by id ASC");
		return $sql->fetchAll();
	}

	public function findList()
	{
		$factories = $this->index();
		$list = array();
		foreach ($factories as $factory) {
			$list[$factory['id']] = $factory;
		}
		return $list;
	}

	public function create($data){
		$query = $this->db->insert('factory', $data);
		return $query;
	}

	public function show($id){
		$query = $this->db->select()->from('factory')->where('id=?',$id);
		return $this->db->fetchRow($query);
	}

	public function delete($id){
		$sql = $this->db->delete('factory', 'id='.$id);
		return $sql;
	}

	public function update($id, $data){
		$sql = $this->db->update('factory', $data, 'id='.$id);
		return $sql;
	}
}