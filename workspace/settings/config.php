<?php

# helper auto-load
$loadHelpers = array();

# defines
define('HOMEDIR','voxo'); // SITE DIRECTORY WAY

define('HASHKEY','voxo'); // DONT CHANGE LATER USE ON USER-TABLE'S PASSWORD DATA! 

$_activeDB = 'default';

$_db['default']['hostname'] = "localhost";
$_db['default']['username'] = "root";
$_db['default']['password'] = "";
$_db['default']['database'] = "voxostart";
$_db['default']['dbdriver'] = "mysql";
$_db['default']['charset'] 	= "utf8";
