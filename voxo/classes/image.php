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

Class Image{

	var $imageX;
	
	var $imageY;
	
	var $ratio = true;
	
	var $enlarge = false;
	
	var $quality = 100;
	
	var $gdVersion = 2;
	
	var $name;
	
	var $addEnd; 
	
	var $display = false;
	
	var $text	= false;
	
	var $textLeft	= 10;
	
	var $textTop	= 10;
	
	var $textRight;
	
	var $textBottom;
	
	var $textColor = '#FFF';
	
	var $textAlpha = 0;
	
	var $textVertical = false;
	
	var $textSize = 5;
	
	var $textMiddle = false;
	
	var $textCenter = false;
	
	var $textShadow;
	
	var $textShadowAlpha = 10;
	
	var $textShadowColor = '#000';
	
	var $textFont;
	
	var $textAngle;
	
	var $watermark;
	
	var $watermarkTop = 0;
	
	var $watermarkLeft = 0;
	
	var $watermarkBottom;
	
	var $watermarkRight;
	
	var $watermarkAlpha = 100;
	
	var $watermarkCenter = false;
	
	var $watermarkMiddle = false;
	
	var $save = false;
	
	protected $finalName;

protected function init()
	{
	$this->imageX = null;
	$this->imageY = null;
	$this->ratio = true;
	$this->enlarge = false;
	$this->quality = 100;
	$this->name = null;
	$this->addEnd = null; 
	$this->display = false;
	$this->text	= false;
	$this->textLeft	= 10;
	$this->textTop	= 10;
	$this->textRight = 0;
	$this->textBottom = 0;
	$this->textColor = '#FFF';
	$this->textAlpha = 0;
	$this->textVertical = false;
	$this->textSize = 5;
	$this->textMiddle = false;
	$this->textCenter = false;
	$this->textShadow = null;
	$this->textShadowAlpha = 10;
	$this->textShadowColor = '#000';
	$this->textFont = null;
	$this->textAngle = null;
	$this->watermark = null;
	$this->watermarkTop = 0;
	$this->watermarkLeft = 0;
	$this->watermarkBottom = 0;
	$this->watermarkRight = 0;
	$this->watermarkAlpha = 100;
	$this->watermarkCenter = false;
	$this->watermarkMiddle = false;
	}

public function getName()
	{
		return V::getFileFullName($this->finalName);
	}

public function createFrom($im, $type = '')
	{
	if(!$type)
		{
		$imageSize = getimagesize($im);
		$type = $imageSize[2];
		}
	
	if($type == IMAGETYPE_JPEG)
		return imagecreatefromjpeg($im);
	else if($type == IMAGETYPE_GIF)
		return imagecreatefromgif($im);
	else if($type == IMAGETYPE_PNG)
		return imagecreatefrompng($im);
	}

public function process($src)
	{	
	if($this->display)
		header('Content-type: image/jpeg');
	
	$pathInfo = pathinfo($src);
	$imageSize = getimagesize($src);
	$type = $imageSize[2];

	$imgIn = $this->createFrom($src,$type);
	
	if($this->imageX || $this->imageY)
		{
		if($this->ratio)
			{
			if(($this->imageX && !$this->imageY))
				{
				$this->imageY = ($this->imageX/$imageSize[0]) * $imageSize[1];	
				}
			else if((!$this->imageX && $this->imageY))
				{
				$this->imageX = ($this->imageX/$imageSize[1]) * $imageSize[0];	
				}
			else if(($this->imageX && $this->imageY) && ($imageSize[0] == $imageSize[1])) // width büyükse height'tan
				{
				if($this->imageX > $this->imageY)
					$this->imageY = $this->imageX;
				else
					$this->imageX = $this->imageY;
				}
			else if(($this->imageX && $this->imageY) && ($imageSize[0] > $imageSize[1])) // width büyükse height'tan
				{
				$ratio = $imageSize[0] / $this->imageX;
				$this->imageY = $imageSize[1] / $ratio;
				}
			else if(($this->imageX && $this->imageY) && ($imageSize[1] > $imageSize[0])) 
				{
				$ratio = $imageSize[1] / $this->imageY;
				$this->imageX = $imageSize[0] / $ratio;
				}
			}
		else 
			{
			if(!$this->imageY)
				$this->imageY = $imageSize[1];	
			else if(!$this->imageX)
				$this->imageX = $imageSize[0];	
			}
		
		if(!$this->enlarge)
			{
			if($this->imageX > $imageSize[0] && $this->imageY > $imageSize[1]) // if large than original image
				{
				$this->imageX = $imageSize[0];
				$this->imageY = $imageSize[1];
				}
			}
		
		if($this->gdVersion == 1) 
			{
			$imgOut = imagecreate($this->imageX, $this->imageY);
			imagecopyresized($imgOut, $imgIn, 0, 0, 0, 0, $this->imageX, $this->imageY, $imageSize[0], $imageSize[1]);
			} 
		else if($this->gdVersion == 2) 
			{
			$imgOut = imagecreatetruecolor($this->imageX, $this->imageY);
	
			if($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) // transparent fix for png and gif
				{
			    imagealphablending($imgOut, false);
			    imagesavealpha($imgOut,true);
			    $transparent = imagecolorallocatealpha($imgOut, 255, 255, 255, 127);
			    imagefilledrectangle($imgOut, 0, 0, $this->imageX, $this->imageY, $transparent);
				}
			
			imagecopyresampled($imgOut, $imgIn, 0, 0, 0, 0, $this->imageX, $this->imageY, $imageSize[0], $imageSize[1]);
			}
		}
	else
		{
		$imgOut = $imgIn;
		
		if($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) // transparent fix for png and gif
			{
		    imagealphablending($imgOut, false);
		    imagesavealpha($imgOut,true);
		    $transparent = imagecolorallocatealpha($imgOut, 255, 255, 255, 127);
		    imagefilledrectangle($imgOut, 0, 0, $this->imageX, $this->imageY, $transparent);
			}
		}
	
	if($this->text) 
		$this->text($imgOut);
	
	if($this->watermark) 
		$this->watermark($imgOut);
	
	/*
	 * 
	 * GELİŞTİRME NOKTASI
	 * Burada $imgOut değişkeni üzerinde tutulan görüntüye
	 * yeni özellikler eklenmeye devam edilebilir.
	 * 
	 */

	if($this->display)
		$this->finalName = null;
	else if($this->name)
		$this->finalName = $pathInfo['dirname'].DIRECTORY_SEPARATOR.$this->name.'.'.$pathInfo['extension'];
	else if($this->addEnd)
		$this->finalName = $pathInfo['dirname'].DIRECTORY_SEPARATOR.$pathInfo['filename'].'-'.$this->addEnd.'.'.$pathInfo['extension'];
	else
		$this->finalName = $src;
	
	if($type == IMAGETYPE_JPEG)
		{
		imagejpeg($imgOut, $this->finalName, $this->quality);
		}
	else if($type == IMAGETYPE_GIF)
		{
		imagegif($imgOut, $this->finalName, $this->quality);
		}
	else if($type == IMAGETYPE_PNG)
		{
		$pngQuality = ($this->quality - 100) / 11.111111;
		$pngQuality = round(abs($pngQuality));
		imagepng($imgOut, $this->finalName, $pngQuality);
		}
	
	if(!$this->save) $this->init(); // son değişikliklerin kaydedilmesi istenmiyorsa değişkenler işlem sonrası default değerlerine çekiliyor
	return $this->getName();
	}

public function copyMerge($dstImg, $srcImg, $dstX, $dstY, $srcX, $srcY, $srcW, $srcH, $pct) // imagecopymerge fix for png
	{
	$cut = imagecreatetruecolor($srcW, $srcH);
	imagecopy($cut, $dstImg, 0, 0, $dstX, $dstY, $srcW, $srcH);
	imagecopy($cut, $srcImg, 0, 0, $srcX, $srcY, $srcW, $srcH);
	imagecopymerge($dstImg, $cut, $dstX, $dstY, 0, 0, $srcW, $srcH, $pct);
	} 

public function watermark(&$im)
	{
	$imageX = imagesx($im);
	$imageY = imagesy($im);
	
	$watermark = $this->createFrom($this->watermark);
	
	$watermarkX = imagesx($watermark);
	$watermarkY = imagesy($watermark);
	
	if($this->watermarkRight)
		$this->watermarkLeft = $imageX - $watermarkX - $this->watermarkRight;
	
	if($this->watermarkBottom)
		$this->watermarkTop = $imageY - $watermarkY - $this->watermarkBottom;
	
	if($this->watermarkCenter)
		$this->watermarkLeft = ($imageX - $watermarkX) / 2;
	
	if($this->watermarkMiddle)
		$this->watermarkTop = ($imageY - $watermarkY) / 2;
	
   	$this->copyMerge($im, $watermark, $this->watermarkLeft, $this->watermarkTop, 0, 0, $watermarkX, $watermarkY, $this->watermarkAlpha); 
	}

private function text(&$im)
	{
	$imageX = imagesx($im);
	$imageY = imagesy($im);
	
	if($this->textVertical) $this->textAngle = 90;
	
	if($this->textAlpha > 0)
		$textColor = $this->colorAllocateAlpha($im,$this->textColor, $this->textAlpha); 
	else
		$textColor = $this->colorAllocate($im,$this->textColor); 
	
	if($this->textRight || $this->textBottom || $this->textCenter || $this->textMiddle)
		{
		if(!$this->textFont)
			{
			$charWidth = imagefontwidth($this->textSize);
			$charHeight = imagefontheight($this->textSize);
			
			if($this->textVertical)
				{
				$textWidth =  $charHeight;
				$textHeight = $charWidth * strlen($this->text);
				}
			else 
				{
				$textWidth =  $charWidth * strlen($this->text);
				$textHeight = $charHeight;
				}
			}
		else 
			{
			$ttfBox = imagettfbbox($this->textSize, $this->textAngle, $this->textFont, $this->text);
			$ttfBoxZeroAngle = imagettfbbox($this->textSize, 0, $this->textFont, $this->text);
			
			$textWidth 			= $ttfBox[4] - $ttfBox[0];
			$textHeight 		= abs($ttfBox[3] - $ttfBox[1]);
			$angleCharHeight 	= abs($ttfBox[3] - $ttfBox[5]);
			}
		
		if($this->textCenter)
			{
			$this->textLeft = ($imageX - $textWidth) / 2;
			}
		else if($this->textRight)
			{
			$this->textLeft = $imageX - $textWidth - $this->textRight;
			}
		
		if($this->textMiddle)
			{
			if($this->textVertical || $this->textFont)
				{
				$this->textTop = ($imageY - $textHeight) / 2;
				if($this->textAngle < 180)  $this->textTop += $textHeight;
				}
			else 
				{
				$this->textTop = ($imageY - $textHeight) / 2;
				}
			}
		else if($this->textBottom)
			{
			$this->textTop 	= $imageY - $this->textBottom;
			
			if(!$this->textFont && !$this->textVertical) $this->textTop -= ($charHeight / 3);
			
			if($this->textFont)
				{
				if($this->textAngle > 90)  $this->textTop = $this->textTop - ($angleCharHeight/2*1.3);
				if($this->textAngle > 180)  $this->textTop -= $textHeight;
				if($this->textAngle > 270)  $this->textTop = $this->textTop + ($angleCharHeight/2*1.3);
				// Bottom uyumluluğu için düzeltmeler yapıldı. 360 derece $textAngle için son limittir..
				// 360 dereceden yukarıda düzgün çalışmaz. Ki o kadar döndürmenin gereği yok ;)
				}
			}
		}

	if($this->textFont)
		{
		if($this->textShadow)
			imagettftext($im, $this->textSize, $this->textAngle, $this->textLeft+$this->textShadow, $this->textTop+$this->textShadow, $this->colorAllocateAlpha($im,$this->textShadowColor, $this->textShadowAlpha), $this->textFont, $this->text);
		
		imagettftext($im, $this->textSize, $this->textAngle, $this->textLeft, $this->textTop, $textColor, $this->textFont, $this->text);
		}
	else
		{
		if($this->textVertical)
			{
			if($this->textShadow)
				imagestringup($im, $this->textSize, $this->textLeft+$this->textShadow, $this->textTop+$this->textShadow, $this->text, $this->colorAllocateAlpha($im,$this->textShadowColor, $this->textShadowAlpha));
			
			imagestringup($im, $this->textSize, $this->textLeft, $this->textTop, $this->text, $textColor);
			}
		else
			{
			if($this->textShadow)
				imagestring($im, $this->textSize, $this->textLeft+$this->textShadow, $this->textTop+$this->textShadow, $this->text, $this->colorAllocateAlpha($im,$this->textShadowColor, $this->textShadowAlpha));
			
			imagestring($im, $this->textSize, $this->textLeft, $this->textTop, $this->text, $textColor);
			}
		}
	
	}

# (input:) 1: &$image (Make image with $this->createFrom) and 2: $color = '#fff' etc..
# (output:) imagecolorallocate(process-with-input)
public function colorAllocate(&$im,$color)
	{
	list($red, $green, $blue) = $this->rgb($color);
    return imagecolorallocate($im ,$red, $green, $blue);
	}

# (input:) 1: &$image (Make image with $this->createFrom), 2: $color = '#fff' etc.., 3: $alpha = 0 between 100 (opacity)
# (output:) imagecolorallocatealpha(process-with-input)
public function colorAllocateAlpha(&$im,$color,$alpha)
	{
	list($red, $green, $blue) = $this->rgb($color);
    return imagecolorallocatealpha($im ,$red, $green, $blue, $alpha);
	}

# (input:) rgb('#FFF');
# (output:) list($red,$green,$blue) = rgb('#FFF');
public function rgb($color) 
	{
	$color = str_replace('#', '', $color);
	if (strlen($color) == 3) $color = str_repeat(substr($color, 0, 1), 2) . str_repeat(substr($color, 1, 1), 2) . str_repeat(substr($color, 2, 1), 2);
	$r = sscanf($color, "%2x%2x%2x");
	$red   = (is_array($r) && array_key_exists(0, $r) && is_numeric($r[0]) ? $r[0] : 0);
	$green = (is_array($r) && array_key_exists(1, $r) && is_numeric($r[1]) ? $r[1] : 0);
	$blue  = (is_array($r) && array_key_exists(2, $r) && is_numeric($r[2]) ? $r[2] : 0);
	return array($red, $green, $blue);
	}

}