<?php
/**
 * Voxo - a PHP 5 framework 
 *
 * @author      Aslan Akali <info@voxo.org>
 * @copyright   Elif İnternet Teknolojileri Tic. Ltd. Şti.  <info@elifweb.com>
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
session_start(); 

# Encoding set
header('Content-Type: text/html; charset=utf-8'); 
@mb_internal_encoding("UTF-8");

# Voxo'nun kalbi
include_once 'voxo/index.php'; 

# VOXO base helper
$baseHelpers = array('v_base');
V::helper($baseHelpers);

# USER workspace helpers
$myHelpers = array('my_base');
V::helper($myHelpers);

# extend edilecek temel sınıflar
include_once V::CORES.'model.php';

# Segment kontrolü yapılarak belli bir alan için 
# helper dosyaları ve ya kodları önceden dahil etmeye yarar
include_once V::SETTINGS.'pre-include.php';

# Controller/Method/Parameter1/Parameter2/.. taraması yapar 
# ..ve bu şekilde (route) URL yolu oluşturulur.
# Sadece route.php tanımlamaları kullanılacaksa 
# önüne # koyarak deaktif edebilirsiniz
V::controllerRoutes();

# URL desenleri ve işlevleri tanımlanan dosya 
include_once V::SETTINGS.'route.php';
