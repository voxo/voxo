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

Class String{

function sef($url) // arama motoruna uygun url üretir, türkçe karakter sorunu çıkarmaz
	{
	include_once(V::SETTINGS.'characters.php');
	
    $string = strip_tags($url);
    $string = preg_replace(array_keys($characters), $characters, $url);
	
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	
	$string = trim($string,'-');
	
	return mb_strtolower($string);
	}


}

?>