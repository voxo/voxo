<?php
Class Login{

function start($nick, $pass, $type = array())
	{
	$loginModel = V::model('login_model');
	
	$pass = $this->passHash(trim($pass));
	
	if($loginModel->check($nick, $pass, $type) == true)
		{
		$_SESSION['nick'] = trim($nick);
		$_SESSION['pass'] = trim($pass);
		$_SESSION['ipcr'] = $this->ipCrypto($pass);
		
		return true;
		}
	
	return false;
	}

function check()
	{
	$loginModel = V::model('login_model');
	
	if(!isset($_SESSION['ipcr']))
		return false;
	
	$check 	= $loginModel->check($_SESSION['nick'], $_SESSION['pass']);
	$ipcr 	= $this->ipCrypto($_SESSION['pass']);
	
	if($check === false && $_SESSION['ipcr'] !== $ipcr)
		{
		return false;
		}
	else 
		{
		$_SESSION['id'] 	= $check['id'];
		$_SESSION['type'] 	= $check['type'];
		}
	}

function passHash($pass)
	{
	return md5($pass.HASHKEY);
	}

function ipCrypto($pass)
	{
	$ip = ip();
	return md5($pass.$ip);
	}


} // END LOGIN CLASS