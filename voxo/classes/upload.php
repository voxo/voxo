<?php 
/**
 * Voxo - a PHP 5 framework 
 *
 * @author      Aslan Akali <info@voxo.org>
 * @copyright   Elif İnternet Teknolojileri Tic. Ltd. Şti. 
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

Class Upload{

	var $name;
	
	var $addEnd;
	
	var $addRand;
	
	var $path;
	
	var $image = FALSE;
	
	var $overwrite = FALSE;
	
	var $fileSize;
	
	var $maxSize = 0;
	
	var $minSize = 0;
	
	var $maxWidth = 0;
	
	var $maxHeight = 0;
	
	var $types = array();
	
	var $mimes = array();
	
	var $save;
	
	protected $error;
	
	protected $extension;

	protected $fileName;
	
	protected $finalName;

	protected $actualFile = array(); // actual file informations (name, path, extension) for cloning

protected function init()
	{
	$this->name = null;
	$this->addEnd = null;
	$this->addRand = null;
	$this->path = null; // remind
	$this->image = FALSE;
	$this->overwrite = FALSE;
	$this->fileSize = null;
	$this->maxSize = 0;
	$this->minSize = 0;
	$this->maxWidth = 0;
	$this->maxHeight = 0;
	$this->types = array();
	$this->mimes = array();
	$this->error = null;
	$this->extension = null;
	}

/*
 * Hata tipleri;
 * minSize, maxSize, maxWidth, maxHeight, move_uploaded_file, not_send_file, type, extension
 */
public function error()
	{
		return $this->error;
	}

public function getName()
	{
		return V::getFileFullName($this->finalName);
	}

public function send($field)
	{
	$file = $_FILES[$field];
	
	$pathInfo = pathinfo($file['name']);
	
	$this->fileSize = round($file['size']/1024, 2);
	
	if($this->name)
		$this->fileName = $this->name;
	else
		$this->fileName = ($pathInfo['filename']); // sef eklenecek (string class)
	
	$this->extension = $pathInfo['extension'];
	
	if($this->image == TRUE)
		$this->validImage();
	// else if video, document vs..
	
	if(!$this->validControl($file['type']))
		return FALSE;
	
	if($file['name'])
		{
		if($this->maxSize && $this->fileSize > $this->maxSize) 
			{
			$this->error = 'maxSize';
			return FALSE;
			}
		
		if($this->minSize && $this->fileSize < $this->minSize) 
			{
			$this->error = 'minSize';
			return FALSE;
			}
		
		if($this->maxWidth || $this->maxHeight)
			$imageSize = getimagesize($file['tmp_name']);
		
		if($this->maxWidth && $imageSize[0] > $this->maxWidth) 
			{
			$this->error = 'maxWidth';
			return FALSE;
			}
		
		if($this->maxHeight && $imageSize[1] > $this->maxHeight) 
			{
			$this->error = 'maxHeight';
			return FALSE;
			}
		
		$this->nameProcess();
		
		if($this->overwrite == FALSE)
			$this->overwrite();
		
		$finalName = $this->fileName.'.'.$this->extension;
		
		if(move_uploaded_file($file['tmp_name'], $this->path.$finalName))
			{
			$this->finalName = $finalName;
			$this->actualFileSave(); // for cloning
			if(!$this->save) $this->init(); // son değişikliklerin kaydedilmesi istenmiyorsa değişkenler işlem sonrası default değerlerine çekiliyor
			return TRUE;
			}
		else 
			{
			$this->error = 'move_uploaded_file';
			return FALSE;	
			}
		
		}
	else 
		{
		$this->error = 'not_send_file';
		return FALSE;
		}
	
	// yeri değiştirilecek
	}

public function nameProcess()
	{
	if($this->addRand && $this->addEnd)
		$this->fileName = $this->fileName.'-'.$this->addEnd.rand(1,$this->addRand);
	else if($this->addRand)
		$this->fileName = $this->fileName.'-'.rand(1,$this->addRand);
	else if($this->addEnd)
		$this->fileName = $this->fileName.'-'.$this->addEnd;
	else
		$this->fileName = $this->fileName;
	}

public function actualFileSave()
	{
		$this->actualFile['fileName'] 	= $this->fileName; // old saved file name
		$this->actualFile['path'] 		= $this->path; // old saved file path
		$this->actualFile['extension'] 	= $this->extension; // old saved file extension
		$this->actualFile['finalName'] 	= $this->finalName; // old saved file extension
	}

public function cloning()
	{
	$this->path 		= $this->actualFile['path'];
	$this->extension 	= $this->actualFile['extension'];
	
	if($this->name)
		$this->fileName = $this->name;
	else
		$this->fileName = $this->actualFile['fileName'];
	
	$this->nameProcess(); // new $this->fileName process for changes on addEnd, addRand etc..
		
	if($this->overwrite == FALSE)
		$this->overwrite();
	
	$finalName = $this->fileName.'.'.$this->extension;
	
	$actualFullWay = $this->actualFile['path'].$this->actualFile['finalName'];
	
	$newFullWay = $this->path.$finalName;
	
	if(copy($actualFullWay, $newFullWay))
		{
		$this->finalName = $finalName;
		if(!$this->save) $this->init(); // (actualFile hariç temizle) son değişikliklerin kaydedilmesi istenmiyorsa değişkenler işlem sonrası default değerlerine çekiliyor
		return TRUE;
		}
	else 
		{
		$this->error = 'file_not_found_for_cloning';
		return FALSE;	
		}
	
	}
	
public function validControl($fileMimeType)
	{
	include_once(V::SETTINGS.'mimes.php');
	
	foreach ($this->types as $type) 
		{
		if(!is_array($mimes[$type]))
			{
			$this->mimes[] = $mimes[$type];
			} 
		else 
			{
			foreach ($mimes[$type] as $type_in) 
				$this->mimes[] = $type_in;
			}
		}
	
	if(!in_array($fileMimeType,$this->mimes)) 
		{
		$this->error = 'type';
		return FALSE;
		}
	else if(!in_array($this->extension,$this->types))
		{
		$this->error = 'extension';
		return FALSE;
		}
	else 
		{
		return TRUE;
		}
	}

public function validImage() // image control with file mimes and file types configure
	{
	$this->types = array('jpg','jpeg','gif','bmp','png');
	}

public function overwrite($number = 0)
	{
	if($number != 0)
		$newName = $this->fileName .'-'.$number;
	else
		$newName = $this->fileName;
	
	if(file_exists($this->path.$newName.'.'.$this->extension))
		{
		$number++;
		$this->overwrite($number);
		}
	else 
		{
		$this->fileName = $newName;
		}
	}

} // Upload Class end..
