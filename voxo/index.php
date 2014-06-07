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

include_once V::SETTINGS.'config.php'; // VOXO configuration file

Class V // for freedom
{

# @const string
const VERSION 			= '0.0.0 ALFA';

const CONTROLLERS 		= 'workspace/controllers/';

const VIEWS 			= 'workspace/views/';

const SYSTEMCLASSES 	= 'voxo/classes/';

const CORES			 	= 'voxo/core/';

const USERCLASSES		= 'workspace/classes/';

const SYSTEMHELPERS 	= 'voxo/helpers/';

const USERHELPERS		= 'workspace/helpers/';

const MODELS			= 'workspace/models/';

const SETTINGS			= 'workspace/settings/';

const SEPARATOR			= DIRECTORY_SEPARATOR;

# @var static
public static 	$activePage 	= '';

# @var array
public static 	$listens 		= array();

private static 	$controllers 	= array(); // Controllers sınıfları hafızaya alınır

private static 	$models		 	= array(); 

private static 	$classes 		= array(); // for singleton : library()

private static 	$helpers 		= array(); // 

private static 	$settings		= array(); // 

public static 	$segment 		= array(); // V::segment[1], V::segment[2] şeklinde dizin adını verir

public static 	$optional 		= array(); // opsiyonel segmentin içeriğini verir

public static 	$specialRegex 	= array( 
		'all' 		=> '(.*)', // all chars allow (dangerous)
		'seg' 		=> '([^/]+)', // segment
		'num' 		=> '([0-9]+)', // only numeric
		'any' 		=> '([a-zA-Z0-9\.\-_%=]+)', // general control
		'var' 		=> '([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+)', // variables control
	);

# @function all

# __constructor, __call vb. metotları çalıştırabilmek için
public static function init()
	{
	return new V();
	}

public function __construct()
	{
	static::segmentAssignment();
	}

# segment değişkeni üzerine atamalar
private static function segmentAssignment()
	{
	$urlString 		= static::urlString();
	$urlStringArr 	= explode('?',$urlString); // get değerlerini alabilmek ve segmentten ayırmak için
	$urlString		= $urlStringArr[0];
	static::$segment = array_filter(explode('/',$urlString)); // static::$segment dizisine dizin isimleri ekleniyor
	}

# dil vb. işlemler için opsiyonel segment belirlemeye yarar
public static function optionalSegment($segmentNu,$regex)
	{
	if(isset(static::$segment[$segmentNu]) && preg_match($regex,static::$segment[$segmentNu]))
		{
			static::$optional = static::$segment[$segmentNu];
			unset(static::$segment[$segmentNu]);
			static::segmentSort();
		}
	}

# segmentleri 1'den başlayarak tekrar sıralar
# bir segment'e unset işlemi yapıldığı durumlardan sonra kullanılması gerekir
# optioanlSegment fonksiyonunda kullanılmaktadır
private static function segmentSort()
	{
	$x = 1;
	foreach (static::$segment as $key => $value) 
		{
		$segmentSort[$x] = $value;
		$x++;
		}
		
	static::$segment = $segmentSort;
	}

# (input:) V::getFileName('a/file/way/filename.php')
# (output:) (string) filename
public static function getFileName($fileWay)
	{
	preg_match_all('|([^\\\:\/]+)(?=\.\w+$)|i', $fileWay, $fileName);
	return $fileName[0][0];
	}

# (input:) V::getFileFullName('a/file/way/filename.jpg')
# (output:) (string) filename.extension
public static function getFileFullName($fileWay)
	{
	preg_match_all('|([^\\\:\/]+)(\.\w+$)|i', $fileWay, $fileName);
	return $fileName[0][0];
	}

# (input:) V::controller('controllername');
# (output:) ..
public static function controller($controller)
	{
	if(!isset(static::$controllers[$controller])) // sınıf diziye eklenmememişse
		{
		if(!preg_match('|.php|', $controller)) // uzantı kontrolü
			$controller = $controller.'.php';
		
		$controllerWay 			= V::CONTROLLERS.$controller;
		$controllerName 		= static::getFileName($controller);
		
		include_once($controllerWay);
		
		# static::$controllers[$controller] = 'admin/controllername.php' ve ya direkt controller dizinindeyse 'controllername' olarak eklenir
		# $controllerName dizin içerisinde controllername ya da direkt controllername gelmişse ayrıştırılıp class hazırlanır
		static::$controllers[$controller] = new $controllerName; 
		}
		
	return static::$controllers[$controller];
	}
	
# V::view('hi',$data) ile view dosyasını aktif eder.
# Tekrar aktif edilebilmeleri için include_once kullanılmadı
# $data exract edilerek $data['degisken'], $data['user']['name'] gibi dizi değişkenleri,
# bir üst satıra çıkarılarak $degisken, $user['name'] şeklinde view içerisine gönderilir
# $_viewFile özel bir değişkendir. exract işlemi ile çakışma olmaması için,
# $_viewFile $data['_viewFile'] şeklinde kullanılamaz
public static function view($_viewFile, &$data = array()) 
	{
		if($data) extract($data);
		include V::VIEWS.$_viewFile.'.php';
	}

# (input:) V::library('classname');
# (output:) (Object) classname
public static function library($class)
	{
	if(!isset(static::$classes[$class])) // sınıf diziye eklenmememişse
		{
		if(file_exists(V::SYSTEMCLASSES.$class.'.php')) // eğer sistem classlarında bu class adı bulunuyorsa..
			{
			$classWay 		= V::SYSTEMCLASSES.$class.'.php';
			$className 		= static::getFileName($classWay);
			}
		else 
			{
			$classWay 		= V::USERCLASSES.$class.'.php';
			$className 		= $class;
			}
		
		include_once($classWay);
		
		static::$classes[$class] = new $className;
		}
		
	return static::$classes[$class];
	}

# (input:) V::helper('helpername');
# (output:) ..
public static function helper($helper)
	{
	if(is_array($helper))
		{ 
		foreach ($helper as $helpername) 
			V::helper($helpername);
		}
	else 
		{
		if(!isset(static::$helpers[$helper])) // sınıf diziye eklenmememişse
			{
			if(file_exists(V::SYSTEMHELPERS.$helper.'.php')) // eğer sistem helperlarında bu helper adı bulunuyorsa..
				$helperWay 		= V::SYSTEMHELPERS.$helper.'.php';
			else 
				$helperWay 		= V::USERHELPERS.$helper.'.php';
			
			include_once($helperWay);
			
			static::$helpers[$helper] = $helper;
			}
		}
	}

# (input:) V::model('modelname');
# (output:) ..
public static function model($model)
	{
	if(!isset(static::$models[$model])) // sınıf diziye eklenmememişse
		{
		if(!preg_match('|.php|', $model)) // uzantı kontrolü
			$model = $model.'.php';
		
		$modelWay 			= V::MODELS.$model;
		$modelName 			= static::getFileName($model);
		
		include_once($modelWay);
		
		static::$models[$model] = new $modelName;
		}
		
	return static::$models[$model];
	}

# Regex kodları içerisine gönderilen özel karakterleri temizler
# ve tam eşleştirmeli bir regex deseni hazırlar.
public static function createPattern($pattern,$pregend = "")
	{
	if(!$pregend) $pregend = 'si';
	$pattern = static::patternFilter($pattern);
	
	return '/^'.$pattern.'$/'.$pregend;
	}

# regex içine gönderilen değişkenlerde :!/| vb. özel karakterlerin
# önüne \ koyarak hata vermesini önler
public static function patternFilter($pattern)
	{
	$specialChars 		= array(':','!','/','|');
	$specialCharsEdit 	= array('\:','\!','\/','\|');
	
	return str_replace($specialChars,$specialCharsEdit,$pattern);
	}

# Gelen $url değerinde ki süslü parantez alanlarını 
# (.*) ifadesi ile regex kontrolüne hazır hale getirir. 
# eğer | ile özel regex (num, any, segment) uygulandıysa
# bunu ayrıştırır ve ilgili $specialRegex[] kodunu uygular. 
protected static function urlRegex($url)
	{
	//$allowQueries = '(\?)(.*?)';
	
	foreach (static::$specialRegex as $key => $val) 
		{
		$url = preg_replace('/{'.static::$specialRegex['var'].':'.$key.'}/',$val,$url); // Change with $specialRegex
		}

	$url = preg_replace('/{'.static::$specialRegex['var'].'}/i',static::$specialRegex['any'],$url); // Change with (.*) regex
	
	try {
		if(preg_match('/{(.*?)}/i', $url)) // halen süslü parantez bulunuyorsa hata bas
			throw new Exception('Error : URL Error', 1);
	
		return static::createPattern($url);
		}
	catch(Exception $e)
		{
   		echo $e->getMessage();
		}
	}

# $_SERVER['REQUEST_URI'] içerisinden sitenin bulunduğu dizini ve sorguları siler ve kalan url'yi verir.
public static function urlString()
	{
	$urlStringArr	= explode(HOMEDIR.'/',$_SERVER['REQUEST_URI'],2);
	$urlStringParse = parse_url($urlStringArr[1]);
	$urlString		= $urlStringParse['path'];
	return '/'.$urlString;
	}

# (input:) listen(404,function(){ .. });
# (process:) add static::$listens[] > $listen parameter and anonymous function ($func)
public static function listen($listen,$func)
	{
	static::$listens[$listen] =& $func;
	}

# (input:) getListen(404);
# (process:) Run 404 anonymous function in the static::getListen[404]
public static function getListen($listen)
	{
	try
		{
		if(isset(static::$listens[$listen]))
			{
			call_user_func(static::$listens[$listen]);
			}
		else
			{
			throw new Exception('Error : '.$listen.' Not Found ', 1); // tanımlanmış listen bulunamadıysa
			}
		}
	catch(Exception $e)
		{
   		echo $e->getMessage();
		exit();
		}
	}

# route() fonksiyonu ile $url deseni ile index'e gelen url bilgisi 
# hafızaya kayıt edilmeden sırasıyla kontrol edilir.
# Eğer url deseni ile gelen url eşleşirse index'te tanımlanan ve 
# $func üzerinde bulunan anonim fonksiyon çalıştırılır.
public static function route($url,$func)
	{
	$pattern 	= static::urlRegex($url);

	if(static::$activePage == '' && preg_match_all($pattern,static::urlString(),$matches))  // aktif sayfa boşsa ve route deseni eşleşirse 
		{
		static::$activePage = $matches[0][0]; // active page url

		array_shift($matches); // Dizinin ilk elemanı olan url silinip anonim fonksiyonun parametreleri bırakılıyor
		
		if(count($matches) >= 1) // eğer 1 ve ya daha fazla parametre varsa
			{
			foreach ($matches as $val)
				$paramList[] = $val[0]; // parametreler $paramList'e toplanıyor
			
			call_user_func_array($func,$paramList);
			}
		else // eğer parametre yoksa
			{
			call_user_func($func);
			}
		}
	}

# segment ve dosya kontrolü yaparak controller'ın 
# olması gerektiği segment numarasını geri döndürür
protected static function controllerSegmentFind()
	{
	$segments = array();
	$segmentPath = array();
	
	for($i=1; $i <= 7; $i++) // 7. segment'e kadar. tarar bu bile fazla.
		{
		if(isset(static::$segment[$i])) // segment doluysa
			{
			if(isset($segmentPath[$i-1])) $xSegment = $segmentPath[$i-1]; else $xSegment = ''; // bir öncesinde segment varsa $xSegment'e atar
			
			$segmentPath[$i] = $xSegment.V::SEPARATOR.static::$segment[$i]; // önceki segment ile şimdiki segmenti birleştirir
			
	    	$filePath = V::CONTROLLERS.$segmentPath[$i]; // birleştirilen segmentlere controller dizin yolunu ekler
			
	   		if (file_exists($filePath) && is_dir($filePath)) 
				$segments[$i] = $segmentPath[$i];
			}
		else 
			{
			break; // baktın artık segment falan geldiği yok, bakmayacaksın.
			}
		}
	return count($segments) + 1; // controller segment'i!
	}

public static function beforeSegment($segmentNumber)
	{
	return array_slice(static::$segment, 0, $segmentNumber);
	}

public static function controllerWay($controllerSegment)
	{
	return implode(V::SEPARATOR,static::beforeSegment($controllerSegment-1)); 
	// controller segmentinin bulunduğu sıradan 1 çıkardık ki beforeSegment() sonuncusu bir önceki segment olacak
	// out example : workspace/controllers/v-admin/super
	}

# class/function/parameter1/parameter2 şeklinde segmentler taranır ve
# Controller, function, parameters eşleşmeleri sağlanırsa aktif edilir
public static function controllerRoutes()
	{
	# eğer aktif sayfa yoksa ve birinci segmentten controller adı ve ya controller dizin adı geliyorsa
	if(static::$activePage == '') 
		{
		$controllerSegment = static::controllerSegmentFind(); // controller segment'i

		if(!isset(static::$segment[$controllerSegment]))
			$controllerFile = 'index';
		else
			$controllerFile = static::$segment[$controllerSegment];
		
		$controllerWay 	=  static::controllerWay($controllerSegment).V::SEPARATOR;
		$controllerFile = $controllerFile.'.php'; 
		
		# controller isimlerinde controller segmentine bakılarak dosya adı taranıyor
		if(file_exists(V::CONTROLLERS.$controllerWay.$controllerFile))
			{
			$controller = V::controller($controllerWay.$controllerFile); 
			$methodSegment = $controllerSegment + 1; // method segmenti
			
			static::methodRoutes($controller, $methodSegment);
			}  // if(in_array(static::$segment[$controllerSegment].. #end
		else
			{ // dosya bulunamadıysa index controller'ın fonksiyonları taranacak
			if(file_exists(V::CONTROLLERS.$controllerWay.'index.php')) // index var mı?
				{
				$controller = V::controller('index.php'); 

				$methodSegment = $controllerSegment; // method segmenti index görünmeyeceği için controller olması gereken segment yerine geçiyor
				
				static::methodRoutes($controller, $methodSegment);
				}
			else 
				{
				static::getListen(404);
				}
			}
		} // if(isset(static::$segment[1]).. #end
	}

private static function methodRoutes(&$controller,$methodSegment)
	{
	if(isset(static::$segment[$methodSegment])) // eğer 2. segment yani metot adı geliyorsa
		{
		if(method_exists($controller, static::$segment[$methodSegment])) // controller'ın methodları gelen methodun olup olmadığı kontrol ediliyor
			{
			$methodName = static::$segment[$methodSegment];
	
			$reflection = new ReflectionMethod($controller, $methodName); // method bilgileri hazırlanıyor
			$getParameters = $reflection->getParameters(); // method bilgilerinden parametreler talep ediliyor
			
			if(!empty($getParameters)) // eğer fonksiyonda parametre bulunuyorsa
				{
				static::parameterRoutes($controller, $methodSegment, $getParameters);
				}
			else // eğer parametre bulunmuyorsa; 
				{
				call_user_func(array($controller, $methodName));
				}
			}
		else 
			{
			$methodName = 'main';
			
			$reflection = new ReflectionMethod($controller, $methodName); // method bilgileri hazırlanıyor
			$getParameters = $reflection->getParameters(); // method bilgilerinden parametreler talep ediliyor
			
			if(!empty($getParameters)) // eğer fonksiyonda parametre bulunuyorsa
				{
				static::parameterRoutes($controller, $methodSegment, $getParameters, 'main');
				}
			else // eğer parametre bulunmuyorsa; 
				{
				// static::getListen(404);
				// route ile devam etçen hacı // bug gibi bişi bura
				}
			}
		}
	else 	// !isset(static::$segment[$methodStartSegment]) / eğer $methodStartSegment segment gelmiyorsa main fonksiyonu çalışacak
		{
		$controller->main(); // $methodStartSegment boşsa controller içerisinde ki main fonksiyonu tetiklenir
		} // if(isset(static::$segment[$methodSegment])).. #end
	}

private static function parameterRoutes(&$controller, $methodSegment, &$getParameters, $main = NULL)
	{
	if(!isset($main))
		{
		$paramStartSegment = $methodSegment + 1; // parametrelerin başlangıç segmenti
		$methodName = static::$segment[$methodSegment];
		}
	else 
		{
		$paramStartSegment = $methodSegment; // parametrelerin başlangıç segmenti
		$methodName = 'main';
		}
	
	foreach ($getParameters as $nu => $parameter) // methodun parametre sırası $nu ile parametre adı $parameter ile döndürülüyor
		{
		if(isset(static::$segment[$nu+$paramStartSegment])) // segment'ten değer parametre ile eşleşiyor mu kontrol ediliyor
			{
			$paramVal = static::$segment[$nu+$paramStartSegment]; // segmentten değer geliyorsa $paramVal'a aktar
			}
		else // parametre olmasına rağmen segment'ten değer gelmiyorsa
			{
			if($parameter->isOptional()) // Parametre'de Default Değer varsa
				$paramVal = $parameter->getDefaultValue();
			else 
				$paramVal = false; // segmentten değer gelmiyor ve default değer yoksa parameter false olarak ayarlandı
			}
		$paramList[$parameter->name] = $paramVal; // parametreler varList'e toplanıyor
		}
		
	call_user_func_array(array($controller, $methodName),$paramList);
	}

public function __destruct()
	{
	if(!isset(static::$activePage)) static::getListen(404);
	}
}

if(count($loadHelpers) > 0) V::helper($loadHelpers); // User helpers - auto-load
V::init(); // __construct, __destruct, __call vb. metotları çalıştırabilmek için init() tetikleniyor
