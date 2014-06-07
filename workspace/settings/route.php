<?php


/*
EXAMPLES

V::route('/video/{url}-{id:num}/',function($url, $id){
	V::controller('videos')->get($url, $id);
});

V::route('/search/',function(){
	V::controller('entries')->search();
});

V::route('/sitemap.xml',function(){
	V::controller('sitemap')->main();
});

V::route('/news',function(){
	$data = V::library('data')->entries(1);
	V::view('site/news', $data);
});

V::route('/{url}',function($url){
	V::controller('page')->main($url);
});

V::optionalSegment(1,'/^([A-Za-z]{2})$/i'); // eğer sadece iki karakter geliyorsa tr, en, fr gibi..
V::listen(404,function(){
	V::view('404');
});

 * 
V::optionalSegment(1,'/^(turkish|english|french)$/i'); // eğer birinci segment turkish, english, french ise
// ya da
V::optionalSegment(1,'/^([A-Za-z]{2})$/i'); // eğer sadece iki karakter geliyorsa tr, en, fr gibi..
// ya da
V::optionalSegment(1,'/^lang-(.+)$/i'); // eğer segment lang- ile başlıyorsa
*/

/*
V::route('/',function(){
	echo 'V start!<br />';
	V::controller('index')->main();
});

V::route('/test',function(){
	$example = V::library('test');
	echo $example->example();
	echo '<br />test directory with V::route()<br />';
});

V::route('/test-{testvar}.html',function($testvar){
	echo 'test-{testvar}.html == test-'.$testvar.'.html<br />';
});

V::route('/test-{testvar}/{testvar2}.html',function($testvar,$testvar2){
	V::controller('home')->ornek($testvar,$testvar2);
});

V::route('/{testvar}test-{testvar2}/{testvar3:num}.html',function($testvar,$testvar2,$testvar3){ // $testvar3 exist numeric regex filter
	echo '{testvar}test-{testvar2}/{testvar3:num}.html == '.$testvar.'test-'.$testvar2.'/'.$testvar3.'.html<br />';
	echo $testvar3.' : (testvar3) exist numeric filter!';
});

V::route('/{testvar}test-{testvar2}/{testvar3}.html',function($testvar,$testvar2,$testvar3){ // $testvar3 not numeric
	echo '{testvar}test-{testvar2}/{testvar3}.html == '.$testvar.'test-'.$testvar2.'/'.$testvar3.'.html<br />';
});
*/
?>