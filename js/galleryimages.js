$(document).ready(function() {
	
	
	/*** Lazy loading of images using ajax call****/
	   var loadingImageUrl = config.baseurljs + 'images/load.gif';
	   var loadMore = true;
	   var offset=12;
	   var isLocked = false;
	   var userName = getValue('user_name');
	   
	 $(window).scroll(function(){ /* window on scroll run the function using jquery and ajax */
       var WindowHeight = $(window).height(); /* get the window height */
       if($(window).scrollTop() + 200 >= $(document).height() - WindowHeight){ /* check is that user scrolls down to the bottom of the page */
           /* display the loading content */
           if((loadMore == true) && (isLocked == false)){
        	   $(".loader_image").show();
        	   loadGalleryImages();
           }
           
           return false;
       }
       return false;
   });
  
  
    function loadGalleryImages(){
    	isLocked = true;
    	
    	$.ajax({
    		url : config.baseurljs + 'profile/artist/loadmoregalleryimages',
    			type : 'POST',
    			data : {offset:offset, user_name:userName},
    			dataType: "json",
    			cache: false,
    			success: function(response) {
    			
    			$(".loader_image").hide();
    			
            	if(response.data.session_exist==false){
            		bootbox.alert("Your session has expired.");
    			}
            	else if(response.status == true){
            		
            		
            		var imageArray = eval(response.data.imageDataArray);
            		
            		offset = offset + imageArray.length;
            		
            		if(imageArray.length < 12){
            			loadMore = false;
            		}
            		
            		for(var i = 0; i < imageArray.length; i++) {
            			
            			var obj = imageArray[i];
            		    $( "#galleryImageSection" ).append($('#newImageTemplate').tmpl(obj));
            		    
  						$('.gallery-image-div').hover(
  								function(){
  					    			$(this).find('.caption').slideDown(250); //.fadeIn(250)
  					            },
  					            function(){
  					            	$(this).find('.caption').slideUp(250); //.fadeOut(205)
  					            }
  					    );
            		}
            		isLocked = false;
            	}
            	else{
            		loadMore = false;
            		return false;
            	}

            },
            error: function(request) {
            	$(".loader_image").hide();
                bootbox.alert("There seems to be some issue with the network connectivity. Please try again later!!");
                return false;
            }
        });
    	
    	return true;
    }
    
    function getValue(id) {
    	var value = '';
    	if (document.getElementById(id) != null){
    		value = document.getElementById(id).value;
    	}
    	return value;
    }
});