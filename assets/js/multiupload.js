(function( $ ){
  var methods = {
    init : function( options ) { 
        
        if (("addEventListener" in window) && ("FileReader" in window) && ("FormData" in window)){
            var formdata, input;
            
            formdata = new FormData()
    
            input = this.change(function(){
                
                $.each(this.files, function(index, file) {                   
                        
                    var reader = new FileReader();
                    
                    reader.onloadend = function (e) { 
                        var element = $("<div></div>").html(file.name);
                        $("#upload-cont").append(element);
                    };
                    
                    reader.readAsDataURL(file);
                    
                    formdata.append("files[]", file);
                
                });
                
                
                if ($("#confirm").size() == 0) {
                    var confirm = $("<input/>").attr({type: "submit", value: "Upload these files", id: "confirm"}).click(function(){
                        var xhr = new XMLHttpRequest();
    
                        // XHR2 has an upload property with a 'progress' event
                        xhr.upload.addEventListener(
                            "progress", 
                            function (e) {
                                if (e.lengthComputable) {
                                    var percentage = Math.round((e.loaded * 100) / e.total);
                                    $("#progress-bar").css("width", percentage + "%");
                                    $("#progress-text").html(percentage + " %");
                                    console.log("Percentage loaded: ", percentage);
                                }
                            }, 
                            false
                        );
 
                        // XHR2 has an upload property with a 'load' event
                        xhr.upload.addEventListener("load", function (e) { $("#progress-bar").css("width", "100%"); }, false);
 
                        // Begin uploading of file
                        xhr.open("POST", window.location);
 
                        xhr.onreadystatechange = function(){
                            if (this.readyState == 4) {
                                if ((this.status >= 200 && this.status < 300) || this.status == 304) {
                                    //if (this.responseText != "") {
                                    //    alert(xhr.responseText);
                                    //}
                                    $("#clear-files").show();
                                }
                            }
                        };
 
                        xhr.send(formdata);
                    });
                
                    $("#upload-cont").append(confirm);
                }
                
                $("#clear-files").click(function(){
                    window.location.reload();
                });
            });
    
            $("#upload-link").css("display", "inline-block").click(function(){
                input.trigger("click");
            });
            
        }else
            alert("Please upgrade your web browser");
    }
  };
 
  $.fn.multiUpload = function( method ) {
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.multiUpload' );
    }    
  
  };
 
})( jQuery );
 
jQuery(document).ready(function(){
    $("#upload").multiUpload();
});