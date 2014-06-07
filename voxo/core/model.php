<?php
Class Vmodel{

public $db = '';

function __construct() 
	{
	$this->db = V::library('db');
	$this->db->connect();
	}
	

}
?>