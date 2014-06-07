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
 */

# TEMEL FONKSİYONLAR 

# ABCD gibi bir string'i array('A','B','C','D') şeklinde bir dizi haline getiren str_split'in multibyte desteklisi
function mb_str_split($str) 
	{
    return preg_split('~~u', $str, null, PREG_SPLIT_NO_EMPTY);
	}

# KARAKTER DEĞİŞTİRİCİ FONKSİYON! Karakter değiştiricide Türkçe karakter sorununu çözen multibyte destekli fonksiyonu
function mb_strtr($str, $from, $to) 
	{
	return str_replace(mb_str_split($from), mb_str_split($to), $str);
	}

function cutText($str, $length)
	{
	return mb_substr(strip_tags($str),0,$length,'UTF-8');
	}

function addEnd($fileName, $addCode)
	{
	$pathInfo = pathinfo($fileName);
	
	return $pathInfo['filename'].'-'.$addCode.$pathInfo['extension'];
	}

# ip() : ... | kullanıcı IP'sini döndürür 
function ip()
	{
		return getenv("REMOTE_ADDR");
	}

# direct() : ... | php yönlendirmesi çalışmazsa önce meta sonra javascript yönlendirmesini aktif eden fonksiyon 
function direct($url)
	{
	if(headers_sent())
		{
		@header('Location: '.$url);
		}
	else
		{
		echo '<meta http-equiv="refresh" content="0;URL='.$url.'">';
		echo '<script language="javascript">location.href = "'.$url.'"</script>';
		}
		
	exit();
	}

function directtime($url,$time = 1) // süreli yönlendirme
	{
		clearing($url);
		echo '<meta http-equiv="refresh" content="'.$time.';URL='.$url.'">';
	}

function sys($flag, $process = NULL, $newMessage = NULL)
	{
	if(!isset($flag)) $flag = 'success';
	
	if(!isset($process))
		$message = 'İşlem başarılı!';
	else if($process == 'delete')
		$message = 'İçerik silme işlemi başarılı!';
	else if($process == 'update')
		$message = 'Güncelleme işlemi başarılı!';
	else if($process == 'insert')
		$message = 'Ekleme işlemi başarılı!';
	
	if($newMessage !== NULL) $message = $newMessage;
	
	return '<div class="alert alert-'.$flag.'">  
					<a class="close" data-dismiss="alert">×</a>  
					'.$message.'
			</div>';
	}

function justDate($date)
	{
	$dateAndTime = explode(' ', $date);
	$date = $dateAndTime[0];
	$dateArr = explode('-', $date);
	$dateArr = array_reverse($dateArr);
	return implode('-', $dateArr);
	}

function justTime($date)
	{
	$dateAndTime = explode(' ', $date);
	$dateAndTime[1] = mb_substr($dateAndTime[1], 0, -3);
	return $dateAndTime[1];
	}
	 
function xmlDateTime($tarih) 
	{
		list($yil,$ay,$gun,$saat,$dakika,$saniye) = mb_split("[-\ \:]",$tarih);
		$tarih = "$yil-$ay-$gun"."T"."$saat:$dakika:$saniye+00:00";
		return($tarih);
	}

function sitemapBlock($loc,$freq, $pri)
	{
	return 	"\t<url>
				\t\t<loc>".$loc."</loc>
				\t\t<changefreq>".$freq."</changefreq>
				\t\t<priority>".$pri."</priority>
			\t</url>\n";
	}

# mailsend() : e-mail send function | temel e-posta gönderim fonksiyonu 
function mailsend($mymail,$konu,$mesaj,$gonderenAd,$gonderenMail) 
	{ 
		$headers = "MIME-Version: 1.0\n"; 
		$headers .= "Content-type: text/html; charset=utf-8\n"; 
		$headers .= "X-Mailer: PHP\n"; 
		$headers .= "X-Sender: PHP\n"; 
		$headers .= "From: $gonderenAd<$gonderenMail>\n"; 
		$headers .= "Reply-To: $gonderenAd<$gonderenMail>\n"; 
		$headers .= "Return-Path: $gonderenAd<$gonderenMail>\n"; 
		return mail($mymail,$konu,$mesaj,$headers); 
	}

# epostakontrol() : e-mail control function | e-posta kontrol fonksiyonu 
function mailcontrol($mailToValidate) 
	{ 
        $regexp = "^[_a-z0-9-]+(\.[a-z0-9-]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$"; 
        if(eregi($regexp,$mailToValidate)) { 
            return 1; 
        }else{ 
            return 0; 
        } 
	}
	
function baseUrl($add = '')
	{
	$baseUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
	$baseUrl .= '://'. $_SERVER['HTTP_HOST'];
	$baseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	return $baseUrl.$add;
	}

function cleanURL($add = '') // full url - except query and #bla.. bla..
	{
	$cleanUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
	$cleanUrl .= '://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	$cleanUrl = strtok($cleanUrl,'?#');
	
	return $cleanUrl.$add;
	}

function headCreate($settings = array())
	{
	if(isset($settings['title']) && !empty($settings['title'])) 
		$head = "<title>{$settings['title']}</title>\n";
	
	if(isset($settings['description']) && !empty($settings['description'])) 
		$head .= "<meta name=\"description\" content=\"{$settings['description']}\" />\n";
	
	if(isset($settings['keywords']) && !empty($settings['keywords'])) 
		$head .= "<meta name=\"keywords\" content=\"{$settings['keywords']}\" />\n";
	
	if(isset($settings['head']) && !empty($settings['head'])) 
		$head .= $settings['head']."\n";
	
	if(isset($settings['gglwm']) && !empty($settings['gglwm'])) 
		$head .= $settings['gglwm']."\n";
	
	return $head;
	}
	
function pathInformations()
	{
 	$indicesServer = array('PHP_SELF',
	'argv',
	'argc',
	'GATEWAY_INTERFACE',
	'SERVER_ADDR',
	'SERVER_NAME',
	'SERVER_SOFTWARE',
	'SERVER_PROTOCOL',
	'REQUEST_METHOD',
	'REQUEST_TIME',
	'REQUEST_TIME_FLOAT',
	'QUERY_STRING',
	'DOCUMENT_ROOT',
	'HTTP_ACCEPT',
	'HTTP_ACCEPT_CHARSET',
	'HTTP_ACCEPT_ENCODING',
	'HTTP_ACCEPT_LANGUAGE',
	'HTTP_CONNECTION',
	'HTTP_HOST',
	'HTTP_REFERER',
	'HTTP_USER_AGENT',
	'HTTPS',
	'REMOTE_ADDR',
	'REMOTE_HOST',
	'REMOTE_PORT',
	'REMOTE_USER',
	'REDIRECT_REMOTE_USER',
	'SCRIPT_FILENAME',
	'SERVER_ADMIN',
	'SERVER_PORT',
	'SERVER_SIGNATURE',
	'PATH_TRANSLATED',
	'SCRIPT_NAME',
	'REQUEST_URI',
	'PHP_AUTH_DIGEST',
	'PHP_AUTH_USER',
	'PHP_AUTH_PW',
	'AUTH_TYPE',
	'PATH_INFO',
	'ORIG_PATH_INFO') ;
	
	echo '<table cellpadding="10">' ;
	foreach ($indicesServer as $arg) 
		{
	    if (isset($_SERVER[$arg])) 
	    	{
	        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
	    	}
	    else 
	    	{
	        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
	    	}
		}
	echo '</table>' ;	
	}

function error($errorMsg)
	{
	$out = '<div class="error">';
	foreach ($errorMsg as $msg) 
		{
		$out.= $msg.'<br>';
		}
	$out.= '</div>';
	
	return $out;
	}

function success($successMsg)
	{
	return '<div class="success">'.$successMsg.'</div>';
	}

	