<?php
/**
 * Voxo - a PHP 5 framework 
 *
 * @author      Aslan Akali <info@voxo.org>
 * @copyright   2013 Uğur Akçıl
 * @copyright   2013 Aslan Akali
 * @link        http://www.voxo.org
 * @license     http://www.voxo.org/license
 * @version     0.0.0 ALFA
 * @package     Voxo
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

                                                  -/                  
                                                /v/                   
               `                              .ovo                    
              `/o+:`            ``````       .xvx                     
                `+vv+-`.-:/+oxvvvvvvvvvxxo/::xvv-                     
                  ovvvvvvvvvvv++/::::/++ovvvvvvv.                     
                  -vvvvvx:-.`/           `/vvvvvvo-                   
                .+vvvvvv/    +            ovvvxvvvvx:                 
              `/vvv:-ovvx`               -vvv/`.+vvvvo.               
             .xvvo-  `ovvo              `xvv/    .vvvvv:              
            .xvv:     `xvv:             /vv+      //vvvv/             
           `xvv:       .vvx`           .vvo`      - :vvvv/            
           ovv/         /vv/          .xvx`      `+  /vvvv:           
          .vvv`         `ovv.        `xvv.        `   xvvvv`          
          :vvv`          .vv/        ovv/             +vvvv/          
          /vvv`           +vx`      .vvo              :vvvv+          
          -vvv/           `vv:      ovv.              /vvvv+          
          `xvvv.           +vv`    :vvo               +vvvv:          
           -vvvx.          .vv/   `vvv.              .vvvvv`          
           `/vvvv:          ovv` `ovv+              .xvvvv-           
             :vvvv+.        :vv/ :vvv.             -xvvvv:            
              .ovvvv/.      `vvv`+vv+            `+vvvvo.             
               `:vvvvv/.     ovvovvv.          `/xvvvx:`              
                 -vxvvvv+.`  /vvvvvx        `./xvvvvo.                
                  +`-ovvvvx/-/vvvvvx`````.:+ovvvvvv+`                 
                  /   .+vvvvvvvvvvvvvvxxvvvvvvvvv:+.                  
                  /     .oxxvvvvvvvvvvvvvvvvxo/x- :.                  
                  -      .: -+vvvvvvvx+/:v:.   :. .`                  
                  :      :/   -vvvx:`    +     -`                     
                              .vv+       :     -`                     
                              -vv`       o     :`                     
                              -/:        `     /.                     
                                -              `                      
                                -                        

*/

Class Db{

public $connect = '';

protected $where = array(); // id = 5, url = "hede-hodo", bla bla
protected $wherePrepare = ''; // id =:id, url =:url
	
public function init()
	{
	$this->where = array();
	$this->wherePrepare = '';
	}

public function connect()
	{
	global $_db;
	global $_activeDB;
	
	$connInfo = $_db[$_activeDB];
	
	try {
			$this->connect = new PDO($connInfo['dbdriver'].':dbname='.$connInfo['database'].';charset='.$connInfo['charset'].';host='.$connInfo['hostname'], $connInfo['username'], $connInfo['password'],
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".$connInfo['charset']."'"));
		}
	catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
public function query($query) // diğer parametreler bakılacak
	{
	return $this->connect->query($query);
	}

public function prepare($sql, $types = array())
	{
	return $this->connect->prepare($sql, $types);
	}

public function complete($sql)
	{
	if(!empty($this->wherePrepare))
		{
		if(stristr($sql, 'WHERE') === FALSE)
			$this->wherePrepare = ' WHERE '.$this->wherePrepare;
		
		$sql = $sql.$this->wherePrepare;
		}
	
	$q = $this->connect->prepare($sql);
	$q->execute($this->where);
	$this->init();
	return $q;
	}

public function where($key, $value = NULL, $type = NULL, $glue = NULL)
	{
	$this->_where($key,$value,'AND','AND');
	}

public function whereAnd($key, $value = NULL, $type = NULL, $glue = NULL)
	{
	$this->_where($key,$value,'AND','AND');
	}

public function orWhere($key, $value = NULL, $type = NULL, $glue = NULL)
	{
	$this->_where($key,$value,'OR','AND');
	}

public function whereOr($key, $value = NULL, $type = NULL, $glue = NULL)
	{
	$this->_where($key,$value,'AND','OR');
	}

public function orWhereOr($key, $value = NULL, $type = NULL, $glue = NULL)
	{
	$this->_where($key,$value,'OR','OR');
	}

private function _where($key, $value = NULL, $type = NULL, $glue = NULL)
	{
	$prepare	= array();
	
	if(is_array($key))
		{
		$whereList		= $key;
		$prepareKeys 	= array_keys($whereList); // array anahtarlarını düzenlemek için değişkene atadık
		$prepare 		= implode(' '.$type.' ',$prepareKeys);
		
		foreach ($whereList as $key => $value) 
			{
			$keySplit = explode(':',$key);
			$this->where[$keySplit[1]] = $value;
			}
		}
	else 
		{
		$prepare = $key;
		$keySplit = explode(':',$key);
		$this->where[$keySplit[1]] = $value;
		}
	
	if(!empty($this->wherePrepare)) $this->wherePrepare .= ' '.$glue.' ';
	$this->wherePrepare .= '('.$prepare.')';
	}

public function insert($data, $table)
	{
	$keysArray 		= array_keys($data); // array anahtarlarını düzenlemek için değişkene atadık
	$keysWithColon 	= ':'.implode(',:',$keysArray); // :title,:entry şeklinde PDO uyumlu olarak anahtarları birleştirir
	$keysWithComma 	= implode(',',$keysArray); // şeklinde PDO uyumlu olarak anahtarları birleştirir
	
	$sql = 'INSERT INTO '.$table.'('.$keysWithComma.') VALUES('.$keysWithColon.')';
	
	$q = $this->connect->prepare($sql);
	
	$colonArr = explode(',',$keysWithColon);
	$dataExecute = array_combine($colonArr,$data);
	
    try {
			$q->execute($dataExecute);
	        return $this->connect->lastInsertId();
    	} 
    catch(PDOExecption $e) 
    	{
	       	echo $e->getMessage();
   	 	}
		
	}

public function update($data, $table)
	{
	foreach ($data as $key => $value) 
		{
		$keys[] = $key.'=:'.$key;
		}
	
	$keysWithComma 	= implode(',',$keys); 
	
	$sql = 'UPDATE '.$table.' SET '.$keysWithComma.' WHERE '.$this->wherePrepare;
	
	$q = $this->connect->prepare($sql);
	
	$dataExecute = array_merge($data,$this->where);
	
	$this->init();
	
    try {
			$q->execute($dataExecute);
	        return true;
    	} 
    catch(PDOExecption $e) 
    	{
	       	echo $e->getMessage();
   	 	}
	}

}
