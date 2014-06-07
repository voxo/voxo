(function( $ ){
  var methods = {
    init : function( options ) {
        
		var settings = $.extend({
			startButton: "uploadStart",
			fileHead: 'image',
			send: 'upload.php',
			extraAttribute: ''
		}, options);

        if (("addEventListener" in window) && ("FileReader" in window)){
            var formdata, input, multiselector, loop = 0, fileids = [], complete = 0, filesButton = this;
    
    		$('#'+$(filesButton).attr('id')).prop("disabled", false);
    		
            input = this.change(function(){
    		
    		
    		multiselector = this; 
                
    			$('#'+settings.startButton).prop("disabled", false);
    			$('#'+$(filesButton).attr('id')).prop("disabled", true);

                $.each(this.files, function(index, file) {  
                    var reader = new FileReader();
    
                    reader.onload = function (e) {
                    	
                    	var nid = vmu_createIdWithFile(file);
                    	var mb = vmu_mbFormat(file.size); 
                    	var justName = ((file.name).split('.'))[0];
                    	
		                $("<img />")
		                   .attr('src', e.target.result)
		                   .attr('id',nid)
		                   .width(100)
		                   .height('auto')
		                   .prependTo('.upl_space')
		                   .wrap(function() {
							return '<div class="media vmu_media" id="vmu_media_'+nid+'">' + 
					  					'<a class="pull-left" href="javascript:void();">' + 
											$(this).text() + 
									'</a>' + 
									  '<div class="media-body" id="vmu_mediabody_'+nid+'">' + 
									    '<div class="media-heading">'+ 
									    
									      '<div class="form-group">' + 
										    '<label for="inputEmail3" class="col-sm-2 control-label">Görsel Başlığı</label>' + 
										    '<div class="col-sm-10">' + 
									    		'<input type="text" class="form-control" id="vmu_title_'+nid+'" value="' + justName + '">' + 
										    '</div>' + 
										  '</div>' + 
									    
									      '<div class="form-group">' + 
										    '<label for="inputEmail3" class="col-sm-2 control-label">Görsel İçeriği</label>' + 
										    '<div class="col-sm-10">' + 
									    		'<input type="text" class="form-control" id="vmu_content_'+nid+'" placeholder="Görsel hakkında içerik">' + 
										    '</div>' + 
										  '</div>' + 
									    
									      '<div class="form-group">' + 
										    '<label for="inputEmail3" class="col-sm-2 control-label"></label>' + 
										    '<div class="col-sm-10">' + 
									    		'liotest' + 
										    '</div>' + 
										  '</div>' + 
									    	//' | <strong>Görsel Boyutu</strong> : ' + mb + 'MB ' + 
									    	// file.name +  
									    '</div>' + 
									    
									    '<div class="form-group">' + 
									    
										    '<button class="btn btn-default btn-xs col-sm-2" type="button" id="vmu_CancelThisUpload_'+ nid +'"><span class="glyphicon glyphicon-minus-sign"></span> Vazgeç</button>' +  
										     
										    '<div class="col-sm-10">'+
											    '<div class="progress progress-striped active" id="progress'+ nid +'">' + 
												  '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">' + 
												    '<span class="sr-only">0%</span>' + 
												  '</div>' + 
												'</div>' + 
											'</div>' + 
											
									    '</div>' + 
									    
									  '</div>' + 
									'</div>' + 
									'<hr />';
							});
					fileids[nid] = nid;
                    };
                    
                    reader.readAsDataURL(file);
                });
                
            });
			
			$(document).on('click', '[id^=vmu_CancelThisUpload]', function(){
				var thisid = $(this).attr('id');
				var fileid_split = thisid.split('vmu_CancelThisUpload_');
				var fileid = fileid_split[1];
				$('#vmu_media_'+fileid).remove();
				fileids[fileid] = 'canceled';
				
				if($('.vmu_media').length == 0)
					{
				    $('#'+settings.startButton).prop("disabled", true);
    				$('#'+$(filesButton).attr('id')).prop("disabled", false);
					}
			});
            
			$('#'+settings.startButton).click(function(){
				var fileslist = multiselector.files;	
                //console.log(fileslist.length);
				for (var i = 0; i < fileslist.length; i++) 
					{
                    var nid = vmu_createIdWithFile(fileslist[i]);
					//console.log(i+':'+nid+':'+fileslist[i].name);
                    if(fileids[nid] == 'canceled') { continue; }
                    
			        var progress_id 	= '#progress' + nid;
			        var title_id 		= '#vmu_title_' + nid;
			        var content_id		= '#vmu_content_' + nid;
			        
            		var xhr = jQuery.ajaxSettings.xhr();	  
				    
					xhr.open('POST', settings.send, true);
					
					xhr.setRequestHeader("Cache-Control", "no-cache");
					xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
					xhr.setRequestHeader("X-File-Name", fileslist[i].fileName);
					xhr.setRequestHeader("X-File-Size", fileslist[i].fileSize);
					//xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					
					(function(progress_id) {
					xhr.onprogress = function(e) {
						
	                    var percentage = 0;
	                    var position = e.loaded || e.position; /*event.position is deprecated*/
	                    var total = e.total;
	                    
	                    if (e.lengthComputable) {
	                        percentage = Math.round(position / total * 100);
							//console.log(position+'='+total+'NEOLUYOLANBURDA!!'+percentage);
	                    }
						
						$(progress_id + ' .progress-bar').css("width", percentage + "%");
						$(progress_id + ' .progress-bar').attr("aria-valuenow", percentage);
						$(progress_id + ' .sr-only').html(percentage + " %");
						
					};
					}(progress_id));
					
					var datasend = new FormData();
					
					datasend.append(settings.fileHead, fileslist[i]);
					datasend.append('content', $(content_id).val());
					datasend.append('title', $(title_id).val());
					
					xhr.send(datasend);
					
					vmu_doRequest(nid,xhr);
					
				    $('#'+settings.startButton).prop("disabled", true);
    				$('#'+$(filesButton).attr('id')).prop("disabled", false);
				}
			});


        }
    }};

$.fn.voxoMultiUploader = function(method) {
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.multiUpload' );
    }
  };
})(jQuery);

function vmu_createIdWithFile(file)
	{
	var filename = file.name;
    var filename_split = filename.split('.');
    var nid = slugify(filename_split[0])+'_'+file.size;
    
    return nid;
	}

function vmu_doRequest(nid, xhr) 
	{
	xhr.onload = function() {    
		if (this.readyState == 4) {
			if ((this.status >= 200 && this.status < 300) || this.status == 304) {
						$('#vmu_CancelThisUpload_'+nid).prop("disabled", true);
						$('#vmu_title_'+nid).prop("disabled", true);
						$('#vmu_content_'+nid).prop("disabled", true);
						$('#vmu_CancelThisUpload_'+nid).html('<span class="glyphicon glyphicon-ok-sign"></span> Yüklendi');
						$('#vmu_CancelThisUpload_'+nid).addClass('btn-success', 1000);
						$('#vmu_mediabody_'+nid).append(this.responseText);
			 	}
			}
		};
	}

function vmu_mbFormat (filesize) 
	{
   	filesize = filesize / 1048576;
   	filesize = filesize.toString();
   	var filesize_arr = filesize.split('.');
   	var filesize2 = filesize_arr[1].substr(0,3);
   	filesize = filesize_arr[0] + ',' + filesize2;
    return filesize;
	}

slugify = function(text) { // < https://gist.github.com/muratcorlu/3698167
	var trMap = {
		'çÇ':'c',
		'ğĞ':'g',
		'şŞ':'s',
		'üÜ':'u',
		'ıİ':'i',
		'öÖ':'o'
	};
	for(var key in trMap) {
		text = text.replace(new RegExp('['+key+']','g'), trMap[key]);
	}
	return text.replace(/[^-a-zA-Z0-9\s]+/ig, '') // remove non-alphanumeric chars
	.replace(/\s/gi, "-") // convert spaces to dashes
	.replace(/[-]+/gi, "-") // trim repeated dashes
	.toLowerCase();
	 
}
