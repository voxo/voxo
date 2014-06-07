Voxo Framework // V for PHP
=============
We have started to work on May 1 on Voxo Framework.
The following contents can be "made work" ​​or "planned work".
You can examine the existing code and you can feedback aslanakali[@]gmail.com about your ideas.

#### ASLAN AKALİ / phpprogramlama.com / aslanakali.com

WHAT IS VOXO?
-------
VOXO stabilize performance and easy is intended to be a light PHP framework.
Beginners and those who want to medium-sized sites can easily use voxo.
Voxo, is a basic MVC system.
VOXO offers you freedom.

BASIC QUESTIONS ABOUT VOXO
-------
WHY VOXO?

Answer;
Why do people work to make and sell a product although same products?
Why not?
Each framework has its own unique ease.
I wanted see some features and amenities in other frameworks but now voxo have these features and amenities.. 


Is a VOXO Micro Framework?
Cevap;
This is the location in the first place.

Will be continuously improve in VOXO?
Cevap;
### Until death do us part.. :)


STANDARTLAR VE ÇALIŞMALAR;
-------
Fonksiyon isimleri her kelimesinin ilk harfleri büyük olacak. 
Dizin ve Dosya isimlerinde tüm harfler küçük. 
Class isimlerinin ilk harfleri büyük kalanı küçük.
Örneğin : example_ex.php, /workspace, /v-admin, Class Cache, V::createPattern($pattern,$pregend)
	
Süslü parantez açılış ve kapanış hizaları aynı olacak. 
Aynı tab derinliğinde açılıp kapanacak.
Class adı haricinde fonksiyonlar, if-else karar yapıları, döngüler vs. tanımlanıp 
süslü parantez alt satırda bir tab girintili başlayacak. 
Her iç kod bloğu: iç karar yapıları, döngüler vs. aynı şekilde tanımlama başlangıcından 
bir tab içeride giriş yapılacak. 
Class parantezleri ise en dipte bulunacak.
Uzun kod bloglarında bitişe "// functionname #end" ve ya "// if($x=11) #end" eklenecek

Örneğin ;
	
	Class Voxo
	{
	public function name($test)
	-{ // 1 tab
	-if($test == 1)
	--{ // 2 tab
	--$test = $test.':test'; // 2 tab
	--} // 2 tab
	
	-return $test; // 1 tab
	-} // name($test) #end
	}

Kod açıklamaları öncelikle Türkçe dilinde yazılacak. 
Daha sonra topyekün çevirisi yapılıp voxo-english gibi farklı bir repositories altına atılır.
Kod yorumları ve klavuz çevirileri için destek olmak isterseniz info[@]voxo.org'a 
e-posta gönderebilirsiniz.

Voxo kullanıcısının kendi class'ını yüklemesi için; 
	$myclass = V::library('myclass');
	$myclass->example();

View'e kodları göndermek için; 
	V::view('mypage',$data);

Route'da Controller çağırmak için; 
	V::controller('mycontroller');

Route'da Controllers'ın alt dizininden bir controller çağırmak için;
	V::controller('admin/mycontroller');

Modal çağırmak için;
	$pagesModel = V::model('v-admin/pages_model.php');
	$pagesModel->add();

Ana dizinde ki index.php dosyasından url şablon (route) ayarlamaları yapılabilir. 

### Örnek sayfa ayarı;
workspace>settings>route.php üzerinden ayarlanabilir.
	
	V::route("product/{title}-no{id:num}.html",function($title,$id){
		V::controller('product')->detail($id);
	});

### Pre Include
workspace>settings>pre-include.php üzerinden ayarlanabilir.

site.com/v-admin gibi v-admin segmentinin altında bulunan tüm alanlara ve ya 
belli başlı bazı bölümlere segment kontrolü yapılarak helper yüklemesi yapılabilir, 
farklı controller aktif edilebilir, bazı kodlar çalıştırılabilir. Örneğin;

	if(isset(V::$segment[1]) && V::$segment[1] == 'v-admin')
		{
			V::helper('admin');
		}

### Dil işlemleri için opsiyonel segment
workspace>settings>route.php üzerinden ayarlanabilir.

Dil vb. işlemler için sadece buna özel ayrılmış ve sistemde bu segment yokmuş gibi 
davrandığı opsiyonel segmentlerdir. 

V::optionalSegment(1,'/^([A-Za-z]{2})$/i'); 
// eğer sadece iki karakter geliyorsa tr, en, fr gibi..

V::optionalSegment(1,'/^(turkish|english|french)$/i'); 
// eğer birinci segment turkish, english, french ise

V::optionalSegment(1,'/^([A-Za-z]{2})$/i'); 
// eğer sadece iki karakter geliyorsa tr, en, fr gibi..

V::optionalSegment(1,'/^lang-(.+)$/i'); 
// eğer segment lang- ile başlıyorsa

### Planlanan Bazı Temel Voxo Sınıfları; 
Image (Tamamlandı), 
Upload (Tamamlandı), 
Database (Devam Ediyor), 
String (Hazırlanacak), 
Cache, Form, Firewall, Cookie, Session, Error, Pagination, Schema..

### Planlanan Bazı Çalışmalar
Sistem hazır gelişmiş bir yönetim paneli ile geliyor olacak. 
Bu farklı bir repositories altında paylaşılacak. (ALFA sürümünden sonra)
Voxo ile geliştiricilerin hazırladığı yazılımlar voxoMarket'te satışa sunulabilecek.
Voxo'nun ayrıca gelişmiş bir kod anlamsızlaştırma yazılımı bulunacak
Geliştiriciler satışa sundukları yazılımları böylelikle güvende tutabilecek.

### Route Sistemi Hakkında Açıklama

Diğer Framework sistemleri route tanımlamalarını 
(Laravel->) Route::get(url,func(){..}), 
(Slim->) $app->get(url,fun(){..}) 
şeklinde yapıyor.

Buraya kadar herşey doğal fakat 
bu FW'ler routelara gönderilen url (şablon) ve func (anonim fonksiyon)ları bir array içerisine kaydediyor.
Yani ne kadar route tanımı varsa anonim fonksiyonlar ile birlikte hafızada tutuluyor daha sonra işlem yapıyor.
Bunun kolaylık getirdiği bir gerçek bazı konularda fakat,  
öncelik performans..

Bu yüzden V::route(url, func(){..}) ile gönderilen her route işleminde Voxo'da önce sırayla kontrol yapılacak.
Yani bu route bilgileri hafızaya eklenmeden kontrol sağlanacak.
url şablonu kontrol edildikten sonra geçerli ise func(){..} anonim fonksiyonu çalıştırılacak.
geçerli değilse diğerleri kontrol edilmeye devam edilecek.
Bir route() çalıştıktan sonra diğer route'ların çalışması önlenecek.

DİZİN YAPISI
-------

	~/voxo
		index.php // VOXO'nun kalbi
		/classes
			image.php
			upload.php
			pagination.php
			...
		/helpers
		v_base.php
		...
	
	~/workspace
		/classes
			index.php
			example.php
			...
		/helpers
		/controllers
			index.php
			example.php
			...
			/v-admin
				index.php
				admin.php
				...
		/model
		/view
			index.php
			example.php
			...
		/settings
			characters.php
			config.php
			route.php
			mimes.php
			pre-include.php

	~/assets
		/fonts
		/images
		/js
		/css
		...
	
	~LICENCE.md
	~README.md
	~guide.pdf
	~index.php
	~route.php
	~config.php
	~.htacess


İLETİŞİM
-------
Aslan Akali 
Elif İnt. Tekn. TİC. LTD. ŞTİ.
phpprogramlama.com
voxo.org
Twitter : @aslanakali
E-Mail : aslanakali[@]gmail.com
