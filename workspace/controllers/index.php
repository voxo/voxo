<?php

Class Index{
	
	function main()
		{
			$data['title'] = 'Merhaba Voxo!';
			$data['entry'] = 'Bu klavyeden nefret ediyorum. Tşk.';
			
			V::view('index',$data);
		}
	
}
