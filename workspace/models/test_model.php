<?php
class Test_model extends Vmodel{
	
function __construct() 
	{
	parent::__construct();
	}
	
public function add($data = array())
	{
	$data = array('title' => $data['title'],
				   'entry' => $data['entry']);
		
	return $this->db->insert($data,'test');
	}
	
public function update($data = array())
	{
	$this->db->where('id =:id', $data['id']);
	
	$data = array('title' => $data['title'],
				   'entry' => $data['entry']);
		
	return $this->db->update($data,'test');
	}
	
public function updateView($data = array())
	{
	$sql = 'UPDATE test SET view = view + 1 WHERE id =:id';
		
	$q = $this->db->prepare($sql);
	
	return $q->execute($data);
	}
	
public function getAllTitles()
	{		
	$sql = "SELECT id, title FROM test";
		
	$data = array();
		
	foreach ($this->db->query($sql) as $row)
	    $data[] = $row;
	
	return $data;
	}

public function mainList($data = null, $start = 0, $limit = 20)
	{
	$sql = "SELECT 	test.id, test.title, test.entry 
			FROM test 
			WHERE 1 = 1";
	
	if(isset($data['search']))
		{
		$sql.= " AND test.title LIKE :search ";
		$data['search'] = '%'.$data['search'].'%';
		}
	
	$sql.= ' ORDER BY sort, id DESC ';
		
	$sql.= ' LIMIT '.$start.','.$limit;
		
	$q = $this->db->prepare($sql);
		
	$q->execute($data);
		
	return $q->fetchAll();
	}
	
public function similar($data = null, $start = 0, $limit = 20)
	{
	$sql = 'SELECT 	test.id, test.title, test.entry 
			FROM test 
			WHERE MATCH (test.title) AGAINST ("'.$data['title'].'" IN BOOLEAN MODE) ';
	
	if(isset($data['id']))
		$sql.= " AND test.id <>:id ";

	if(isset($data['search']))
		{
		$sql.= " AND test.title LIKE :search ";
		$data['search'] = '%'.$data['search'].'%';
		}
	
	$sql.= ' ORDER BY sort, id DESC ';
		
	$sql.= ' LIMIT '.$start.','.$limit;
		
	$q = $this->db->prepare($sql);
	
	$q->execute($data);
		
	return $q->fetchAll();
	}
	
public function mainTotal($data = null)
	{
	$sql = "SELECT COUNT(id) FROM test WHERE 1 = 1";
		
	if(isset($data['search']))
		{
		$sql.= " AND test.title LIKE :search ";
		$data['search'] = '%'.$data['search'].'%';
		}
	
	$q = $this->db->prepare($sql);
		
	$q->execute($data);
		
	return $q->fetchColumn();
	}
	
public function getTest($id)
	{
	$sql = "SELECT test.* 
			FROM test 
			WHERE test.id =:id";
	
	$q = $this->db->prepare($sql);
	
	$data['id'] = $id;
	$q->execute($data);
	
	return $q->fetch();
	}

public function delete($pageid)
	{
	$sql = "DELETE FROM test WHERE id =:id";
	
	$q = $this->db->prepare($sql);
	
	$q->bindParam(':id', $pageid, PDO::PARAM_INT);   
	return $q->execute();
	}
	
	
}
