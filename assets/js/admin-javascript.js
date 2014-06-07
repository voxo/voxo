
function onay(data)
{
	if(data)
		{
	 	var cfm = confirm(data);
		}
	else
		{
		var cfm = confirm("Silme işlemi gerçekleşecek\nDevam etmek istiyor musunuz ?");
		}
	 if(cfm == true){
	 	return true;
	 }
	 return false;
}


CKEDITOR.replace( 'admineditor', {
	language: 'tr',
	toolbar: 
	[
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Print', '-', 'Templates' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent',	 'Indent', '-', 'Blockquote', 'CreateDiv' ] },
		{ name: 'paragraph2', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
		{ name: 'paragraph3', items: [ 'BidiLtr', 'BidiRtl', 'Language' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] }
	]
});

function sortsend(address)
	{
    if (window.ActiveXObject)	 
		var xhr = new ActiveXObject('Microsoft.XMLHTTP');				 
	else			
		var xhr = new XMLHttpRequest();	
	
	xhr.open('POST', address, true);
	
	var datasend = new FormData();
	
	var sortlistText = ''; 
	$('[name^=sortlist]').each(function(index, elem){
		datasend.append($(elem).attr('name'), $(elem).val());
	});
	
	xhr.onload = function() 
		{    
		if (this.readyState == 4) 
			{
			if ((this.status >= 200 && this.status < 300) || this.status == 304) 
				{
				 if (this.responseText != "") 
				 	{
					alert(this.responseText);
				 	}
			 	}
			}
		};
	
	xhr.send(datasend);
	}

function deleteImage(id, address)
	{
	var cfm = confirm("Silme işlemi gerçekleşecek\nDevam etmek istiyor musunuz ?");
	
	if(cfm == true)
		{
		 if (window.ActiveXObject)	 
			var xhr = new ActiveXObject('Microsoft.XMLHTTP');				 
		else			
			var xhr = new XMLHttpRequest();	
			
		xhr.open('POST', address, true);
		
		var datasend = new FormData();
		
		datasend.append('imageid', id);
		
		xhr.onload = function() 
			{    
			if (this.readyState == 4) 
				{
				if ((this.status >= 200 && this.status < 300) || this.status == 304) 
					{
					 if (this.responseText != "") 
					 	{
					 	alert(this.responseText);
						$('#delimg'+id).parent().parent().parent().parent().remove();
						$('#imagediv_'+id).remove();
					 	}
				 	}
				}
			};
		
		xhr.send(datasend);
			
		}
   
	}

function makeMainImage(id,address)
	{
    if (window.ActiveXObject)	 
		var xhr = new ActiveXObject('Microsoft.XMLHTTP');				 
	else			
		var xhr = new XMLHttpRequest();	
	
	xhr.open('POST', address, true);
	
	var datasend = new FormData();
	
	$('[id^=make_main_button_]').each(function(index, elem){
		$(elem).children('span').attr('class','glyphicon glyphicon-star-empty');
	});
	
	datasend.append('imageid', id);
	
	xhr.onload = function() 
		{    
		if (this.readyState == 4) 
			{
			if ((this.status >= 200 && this.status < 300) || this.status == 304) 
				{
				 if (this.responseText != "") 
				 	{
				 	if(this.responseText == 1)
						$('#make_main_button_'+id).children('span').attr('class','glyphicon glyphicon-star');
					else if(this.responseText == 2)
						$('#make_main_button_'+id).children('span').attr('class','glyphicon glyphicon-star-empty');
					else 
						alert('Update error!');
					}
			 	}
			}
		};
	
	xhr.send(datasend);
	}

function makeSliderImage(id,address)
	{
    if (window.ActiveXObject)	 
		var xhr = new ActiveXObject('Microsoft.XMLHTTP');				 
	else			
		var xhr = new XMLHttpRequest();	
	
	xhr.open('POST', address, true);
	
	var datasend = new FormData();
	
	$('[id^=make_slider_button_]').each(function(index, elem){
		$(elem).children('span').attr('class','glyphicon glyphicon-star-empty');
	});
	
	datasend.append('imageid', id);
	
	xhr.onload = function() 
		{    
		if (this.readyState == 4) 
			{
			if ((this.status >= 200 && this.status < 300) || this.status == 304) 
				{
				 if (this.responseText != "") 
				 	{
				 	if(this.responseText == 1)
						$('#make_slider_button_'+id).children('span').attr('class','glyphicon glyphicon-star');
					else if(this.responseText == 2)
						$('#make_slider_button_'+id).children('span').attr('class','glyphicon glyphicon-star-empty');
					else 
						alert('Update error!');
					}
			 	}
			}
		};
	
	xhr.send(datasend);
	}
	
$('#unchecked').click(function () {
	$('input[type="radio"]').prop("checked", false);
});