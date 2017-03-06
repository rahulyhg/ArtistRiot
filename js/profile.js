$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});

    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
 
/******************* Add Artist Review *********************/
    
    $('#reviewform').bootstrapValidator({
    	
    	 live: 'enabled',
		 fields: {
       	 
			 reviewername: {
				  validators: {
		         	 notEmpty: {
		                  message: 'Please enter your name.'
		              },
	                  regexp: {
	                         regexp: /^[a-z\s]+$/i,
	                         message: 'The First Name can consist of alphabetical characters only.'
	                     }
		          }
		        },
		        reviewtitle: {
			          validators: {
			         	 notEmpty: {
			                  message: 'Please enter review title.'
			              }
			          }
			        },
		          
			 review: {
                validators: {
               	 notEmpty: {
                        message: 'Please provide artist review.'
                    },
                    stringLength: {
                        min: 50,
                        message: 'Review must be of atleast 50 characters.'
                    }
                }
            },
            
            rating_score: {
            	excluded: 'false',
            	trigger: 'change',
		          validators: {
		         	 notEmpty: {
		                  message: 'Please provide rating.'
		              }
		          }
		        }
		    
        },
        onSuccess: function(e) {
        
        	//e.preventDefault();
        	
        	$('#reviewform').submit(function() {
        			
        		$.ajax({
         			url : $(this).attr('action'),
        			type : 'POST',
         			data : $(this).serialize(),
         			dataType: "json",
         			async: true,
        			success : function(response) {
        				
        				$("#submitreviewbutton").button('reset');
        				
        				if(response.status == false && response.data.session_exist == false){
        					$("#submitreviewbutton").removeAttr('disabled');
        					openLoginModal();
        				}
        				else if(response.status == true){
        					$('#review-form-display').hide();
        					$('#review-form-response').show();
        				}
        				else if(response.status == false){
        					alert(response.errorMessage);
        				}
        				
        			},
        			error : function(request){
        				
        				$("#submitreviewbutton").button('reset');
        				alert("Could not send the data." + request.responseText);
        				return false;
        			}
         		});
        		
        		return false;
        		
        		});
        
        },
        onError: function(e) {
            
        	console.log(e);
        	
        }
    }); 
    
    
  /*  
    $("#submitreviewbutton").click(function(){
    	//$("#reviewform").data('bootstrapValidator').validate();
    });
   */
    
   
    
    /*********** Login Modal for review *****************/
    
$('#loginform').bootstrapValidator({
        
        fields: {
       	    
        	feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            
        	email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required and cannot be empty'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    }
                }
            }
            
            
        },
        onSuccess: function(e) {
            
        	
        	$('#loginform').submit(function() { 
        		
        		//var email = getValue('guest_email');
        		//var password = getValue('guest_password');
        		//var argsString = 'email=' + login_email + '&password=' + password;
        		
        		$.ajax({
        			url : $(this).attr('action'),
        			type : 'POST',
        			data : $(this).serialize(),
        			dataType: "json",
        			async: true,
        			success : function(response) {
        			
        				if(response.status == true){
        					$('#reviewLoginModal').modal('toggle');
        					$('#reviewform').submit();
        					
        				}
        				else{	
        					$('.login_error_message').html(response.errorMessage);
            				$('.login_error_message').css("display", "block");
        				}
        				
        			},
        			error : function(request) {
        				alert("Could not send the data." + request.responseText);
        				return false;
        			}
        		});
        		
        		return false;
        	});
        
        },
        onError: function(e) {
            
        	
        	
        }
    });


function openLoginModal(){
	
	$('#guest_email').val("");
	$('#guest_password').val("");
	$('.login_error_message').html("");
	$('.login_error_message').css("display", "none");
	$('#review_forget_password_section').css("display", "none");
	$('.forgot_password_error_message').css("display", "none");
	$('#review_forgot_password_email').val("");
	$("#reviewLoginModal").modal("show");
}


var forgotpassworddisplay = false;

$('#review_forget_password_link').click(function(){
	if(forgotpassworddisplay == false){
		$('#review_forget_password_section').css("display", "block");
		forgotpassworddisplay = true;
	}
	else if(forgotpassworddisplay == true){
		$('#review_forget_password_section').css("display", "none");
		$('.forgot_password_error_message').css("display", "none");
		$('#review_forgot_password_email').val("");
		forgotpassworddisplay = false;
	}
});

$('#review_forgotpasswordform').bootstrapValidator({
    
    fields: {
    	feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
   	    
    	forgot_password_email: {
            validators: {
                notEmpty: {
                    message: 'Email is required and cannot be empty'
                }
            }
        }
        
    },
    onSuccess: function(e) {
    	$('#review_forgotpasswordform').submit(function() { 
    		
    		var email = getValue('review_forgot_password_email').trim();
    		var argsString = 'forgot_password_email=' + email;
    		
    		$.ajax({
    			url : $(this).attr('action'),
    			type : 'POST',
    			data : argsString,
    			async: true,
    			dataType: "json",
    			success : function(response) {
    				if(response.status == true){
    					$('.forgot_password_error_message').css("display", "block");
    					$('.forgot_password_error_message').html(response.data.emailSent);
    					sendemail();
    				}
    				else{
    					$('.forgot_password_error_message').html(response.errorMessage);
    					$('.forgot_password_error_message').css("display", "block");
    				}
    			},
    			error : function(request) {
    				alert("Could not send the data." + request.responseText);
    			}
    		});
    		
    		return false;
    	});
    }
});

function sendemail(){

	var email = getValue('review_forgot_password_email').trim();
	
	var argsString = 'forgot_password_email=' + email;
	
	$.ajax({
		url : config.baseurljs + 'login/loginform/forgotpassword',
		type : 'POST',
		data : argsString,
		dataType: "json",
		async: true,
		success : function(response) {
			
		},
		error : function(request) {
			alert("Could not send the data." + request.responseText);
			
		}
	});
}

$("#review_fb-login").on("click", function() {
	
	FB.login(function(response) {
			console.log(JSON.stringify(response));
			
        	if(response.authResponse) { // check if user authorized the app
        		loginUserWithFacebook(response.authResponse.accessToken);
        	} else {
	        	alert("Please accept the Facebook access to login with Facebook");
	        }

		},
		{scope: 'email'},
		{auth_type: 'rerequest'});
	

});

function loginUserWithFacebook(accessToken){
	
	 console.log('Welcome!  Fetching your information from Facebook.... ');
	    
	 FB.api('/me', function(response) {
		 	
		 	console.log(JSON.stringify(response));
	        console.log('Successful login for: ' + response.name);
	       
	        var email = response.email;
	        var first_name = response.first_name;
	        var last_name = response.last_name;
	        var fbAccessToken = accessToken;
	        var user_role = $('#user_role').val();
	        
	        var argsString = 'email=' + email;
	        
	        $.ajax({
   			url : config.baseurljs + 'login/loginform/loginWithSocialNetworkForReview',
   			type : 'POST',
   			data : argsString,
   			dataType: "json",
   			success : function(response) {
   				
   				if((response.status == true) && (response.data.email != '')){	
   					
   					$("#reviewer_email").val(response.data.email);
   					$('#reviewform').attr("action", config.baseurljs + 'profile/artistreview/addartistreviewfromguest');
   					$('#reviewform').submit();
   					$('#reviewLoginModal').modal('toggle');
   					
   				}
   				else{
   					$('.login_error_message').html(response.errorMessage);
       				$('.login_error_message').css("display", "block");
   				}
   				
   			},
   			error : function(request) {
   				alert("Could not send the data." + request.responseText);
   				return false;
   			}
   		});
	        
	    });
}

/************************ Google login ******************************/
$("#review_google-login").on("click", function() {

    var po = document.createElement('script');
    po.type = 'text/javascript';
    po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
});


/************ Edit photo form ********************/

	$('#changeprofilepic').hover(
		 function(){
  			$(this).find('.edit-profile-pic').slideDown(250); //.fadeIn(250)
          },
          function(){
          	$(this).find('.edit-profile-pic').slideUp(250); //.fadeOut(205)
          }
	);

	//Image upload button
	$('#uploadbutton').click(function(){
		$('#editprofileimageupload').click();
		
	});

	$('#edit-profile-image').imgAreaSelect({ 
		onSelectChange: preview
	});

	$('#saveimagebutton').click(function(){
		
		
		$("#saveimagebutton").button('loading');
		
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var w = $('#w').val();
		var h = $('#h').val();
		
		$.ajax({
			url : config.baseurljs + 'profile/editprofile/cropandsaveimage',
			type : 'POST',
			data : {x1:x1, y1:y1, w:w, h:h},
			dataType: "json",
			success : function(response) {
				
	        	$("#saveimagebutton").button('reset');
	        	
				if(response.sessionExist == false){
					customAlert('Error', response.errorMessage);
					window.location.href=response_new.data.base_url;
				}
				else if(response.status == true){
					$('.profileimagesavebuttons').css('display','none');
					$('#uploadbutton').css('display','block');
					$('#profile-pic').attr('src', response.data.imageUrl);
					$('#editProfilePic').modal('hide');
					$('#edit-profile-image').attr('src', config.baseurljs + 'images/avatar.png');
					
				}
				else if(response.status == false){
					customAlert('Error', response.errorMessage);
				}
			},
			error : function(request) {
				customAlert('Error', 'Error in page. Please try after some time.');
				$("#saveimagebutton").button('reset');
				return false;
			}
		});
		
	});
	
	$( "#editprofileimageupload" ).on('change', function(){
		
		
		// get selected file
	    var oFile = $('#editprofileimageupload')[0].files[0];
		
	    //Create new form to upload photo 
	    
		var form = new FormData();
		   //append files
		 var file = document.getElementById('editprofileimageupload').files[0];
		  
		 if(file) { 
			  form.append('profileimage', file);
			  form.append('filename', oFile.name);
		 }
		 
		 else{
			 return;
		 }
		
		 $.ajax({
				url : config.baseurljs + 'profile/editprofile/editprofilephoto',
				type :'POST',
				data : form,
				contentType: false, //must, tell jQuery not to process the data
		        processData: false,
		        dataType: "json",
		        success : function(response) {
					
					if(response.sessionExist == false){
						customAlert('Error', response.errorMessage);
						window.location.href=response.data.base_url;
					}
					else if(response.status == true){
						$('#edit-profile-image').attr('src', response.data.imageUrl);
						$('.profileimagesavebuttons').show();
						$('#uploadbutton').hide();
						
					}
					else if(response.status == false){
						customAlert('Error', response.errorMessage);
					}
					
				},
				error : function(request) {
					
					customAlert('Error', 'Error in page. Please try after some time.');
					return false;
				}
			});
		 
		 //Setting image area 
		 
		 var ias = $('#edit-profile-image').imgAreaSelect({ 
			 	instance: true,
				fadeSpeed: 400,
				maxWidth: 250,
				maxHeight: 250,
				minWidth: 150,
				minHeight:150,
				aspectRatio: '1:1',
				handles: true,
				persistent : true,
				enable: true,
				onSelectChange: preview,
				show:true
			});
			ias.update();
			
			ias.setSelection(75, 75, 225, 225, true);
			ias.update();
		
		
		});
	
$('#edit-profile-image').on('load', function () {
		
		var ias = $('#edit-profile-image').imgAreaSelect({ 
		 	instance: true,
			fadeSpeed: 400,
			maxWidth: 250,
			maxHeight: 250,
			minWidth: 150,
			minHeight:150,
			aspectRatio: '1:1',
			handles: true,
			persistent : true,
			enable: true,
			onSelectChange: preview,
			show:true
		});
		
		ias.setSelection(75, 75, 225, 225, true);
		
		ias.update();
		
		return true;
		
	});

$('#cancelimageupload').click(function(){
	
	$("#cancelimageupload").button('loading');
	
	$.ajax({
		url : config.baseurljs + 'profile/editprofile/cancelimageupload',
		type : 'POST',
		data : '',
		dataType: "json",
        success : function(response) {
			
			if(response.sessionExist == false){
				customAlert('Error', response.errorMessage);
				window.location.href=response.data.base_url;
			}
			else if(response.status == true){
				$('#edit-profile-image').attr('src', config.baseurljs + 'images/avatar.png');
				$('#uploadbutton').css('display','block');
				$('.profileimagesavebuttons').css('display','none');
			}
			else if(response.status == false){
				customAlert('Error', response.errorMessage);
			}
			
			$("#cancelimageupload").button('reset');
			
		},
		error : function(request) {
			$("#cancelimageupload").button('reset');
			customAlert('Error', 'Error in page. Please try after some time.');
			return false;
		}
	});
});

	
	$('body').on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal');
    });
	
	$('#editProfilePic').on('hidden.bs.modal', function () {
	   
		$(this).removeData('modal');
		$('#edit-profile-image').imgAreaSelect({remove:true});
		
	});
	
	
	
	
	/************ Edit profile picture ***************/
	
	
	
	/********** Image Gallery upload photos form ********************/
	
$( "#galleryimageupload" ).on('change', function(){
	    
		// get selected file
	    var oFile = $('#galleryimageupload')[0].files[0];
	    $('#photoname').val(oFile.name);
	    //$('#editprofileimagefilename').val(oFile.name);
	    // hide all errors
	    $('.error').hide();
	 
	   
	    // preview element
	    var oImage = document.getElementById('galleryimage');
	    var origImageWidth;
	    var origImageHeight;
	   
	    // prepare HTML5 FileReader
	    var oReader = new FileReader();
	        oReader.onload = function(e) {
	        // e.target.result contains the DataURL which we can use as a source of the image
	        oImage.src = e.target.result;
	        
	        oImage.onload = function() {
	        	origImageWidth = this.width;
	         	origImageHeight = this.height;
	         	$('#imagewidth').val(origImageWidth);
	         	$('#imageheight').val(origImageHeight);
	        }
	       
        	
	    };
	    // read selected file as DataURL
	    oReader.readAsDataURL(oFile);
	    
	    $('.imagesection').css("display", "block");
		
		
	});


	/************* Ajax call to upload new photo in user gallery ********************/

$('#addphotoform').bootstrapValidator({
    
	  fields: {
      	 
		  galleryimageupload: {
               validators: {
              	 
              	 notEmpty: {
	                        message: 'Please select an image.'
	                 },
	                    
              	 file: {
              		 extension: 'jpg,jpeg,png,gif',
              		 type: 'image/jpeg,image/png,image/gif,image/jpg',
              		 maxSize: 2048*1024, 
              		 message: 'Please provide the image with exnesion of type jpg, jpeg, gif or png. File size should be less than 2 MB.'
              	 }
              }
           },
           
	 imagedescription: {
          validators: {
         	 notEmpty: {
                  message: 'Please enter some description.'
              }
          }
        }
	  },
    
      onSuccess: function(e) {
  	  
      	 $('#addphotoform').submit(function() { 
      		
      		 var form = new FormData(document.getElementById('addphotoform'));
      		   //append files
      		 var file = document.getElementById('galleryimageupload').files[0];
      		  if (file) { 
      			  form.append('galleryimageupload', file);
      		   }
      		
      		 $("#uploadimagebutton").button('loading');
      		 
      			$.ajax({
      				url : $(this).attr('action'),
      				type : $(this).attr('method'),
      				data : form,
      				contentType: false, //must, tell jQuery not to process the data
      		        processData: false,
      		        dataType: "json",
      				success : function(response) {
      					
      					$("#uploadimagebutton").button('reset');
      					
      					if(response.status == true){
      						
      						$( "#galleryImageSection" ).prepend($('#newImageTemplate').tmpl(response.data));
      						$('#addphotosmodal').modal('hide');
      						
      						$('.gallery-image-div').hover(
      					            function(){
      					    			$(this).find('.caption').slideDown(250); //.fadeIn(250)
      					            },
      					            function(){
      					            	$(this).find('.caption').slideUp(250); //.fadeOut(205)
      					            }
      					    );  
      					}
      					else{
      						alert(response.errorMessage);
      					}
      					
      					
      				},
      				error : function(request) {
      					$("#uploadimagebutton").button('reset');
      					alert("Could not send the data." + request.responseText);
      					return false;
      				}
      			});
      			
      			return false;
      		});
       
       },
       onError: function(e) {
           
       	//Placeholder for onerror function
       	
       }
   });

	$('.gallery-image-div').hover(
        
		function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    );  
	
	/****** Delete Gallery Image *******/
	
	$(document).on('click', '.delete-image', function () {
		
		var imageId = $(this).children("span.image-id").text();
		
		bootbox.confirm({
		    
			title: 'Delete Photo',
		    message: 'Are you sure you want to delete this photo?',
		    buttons: {
		        'cancel': {
		            label: 'Cancel',
		            className: 'btn-default'
		        },
		        'confirm': {
		            label: 'Confirm',
		            className: 'btn-danger'
		        }
		    },
		    callback: function(result) {
		    	if(result){
		    		deleteImage(imageId);
		    	}
		    	
		    },
		    className:'confirmmodel'
		});
		
	});
	
	/*********** function to delete gallery image ***************/
	
	function deleteImage(imageId){
		
		var divObject = $('#img_' + imageId);
		
		$.ajax({
			url : config.baseurljs + 'profile/managephotos/deletegalleryphoto',
			type : 'POST',
			data: {imageId : imageId},
			dataType: "json",
			async : false,
			success : function(response) {
				
				if(response.status == true){
					$(divObject).remove();
				}
				else if((response.status == false) && (response.data.session_exist==false)){
					var url = response.data.url;
					window.location.href = url;
				}
				else{
					alert(response.errorMessage);
				}
				
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}
	
	
/****** Delete Venue Gallery Image *******/
	
	$(document).on('click', '.delete-venue-image', function () {
		
		var imageId = $(this).children("span.image-id").text();
		
		bootbox.confirm({
		    
			title: 'Delete Photo',
		    message: 'Are you sure you want to delete this photo?',
		    buttons: {
		        'cancel': {
		            label: 'Cancel',
		            className: 'btn-default'
		        },
		        'confirm': {
		            label: 'Confirm',
		            className: 'btn-danger'
		        }
		    },
		    callback: function(result) {
		    	if(result){
		    		deleteVenueGalleryImageImage(imageId);
		    	}
		    	
		    },
		    className:'confirmmodel'
		});
		
	});
	
	/*********** function to delete gallery image ***************/
	
	function deleteVenueGalleryImageImage(imageId){
		
		var divObject = $('#img_' + imageId);
		
		$.ajax({
			url : config.baseurljs + 'profile/managevenuedata/deletevenuegalleryphoto',
			type : 'POST',
			data: {imageId : imageId},
			dataType: "json",
			async : false,
			success : function(response) {
				
				if(response.status == true){
					$(divObject).remove();
				}
				else if((response.status == false) && (response.data.session_exist==false)){
					var url = response.data.url;
					window.location.href = url;
				}
				else{
					alert(response.errorMessage);
				}
				
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}

	
	/************ Ajax call to load artist review **************/
	
	if ($('#artist_review').length) {
		$.ajax({
			url : config.baseurljs + 'profile/artist/getartistreview',
			dataType: "json",
			async : true,
			success : function(response) {
				
				if(response.status == false){
					$('#artist-review-slider').html('Unable to load artist reviews.');
				}
				else if(response.status == true){
					
					var reviewArray = eval(response.data.userReviewData);
					
					if(typeof(reviewArray) == 'undefined'){
						$( "#artist-review-slider" ).html("No Recent Reviews.");
					}
					
					else{
						for(var i = 0; i < reviewArray.length; i++) {
							var obj = reviewArray[i];
							$( "#artist-review-slider" ).prepend($('#artistReviewItemTemplate').tmpl(obj));
						}
						
						$( "div#artist-review-slider div:first-child").addClass( "active" );
						$('.pull-right').show();
					}
					
				}
				$('#testimonialloader').hide();
				
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}
	
	/************ Ajax call to load artist recent images **************/
	
	if ($('#artist-recent-photos').length) {
		$.ajax({
			url : config.baseurljs + 'profile/artist/getartistrecentphotos',
			dataType: "json",
			async : true,
			success : function(response) {
				
				if(response.status == false){
					$('#artist-recent-photos').html('Unable to load recent artist images.');
				}
				else if(response.status == true){
					
					var photosArray = eval(response.data.galleryImageData);
					
					if(photosArray == null){
						$( "#artist-recent-photos" ).html("No Recent Images.");
					}
					else{
						for(var i = 0; i < photosArray.length; i++) {
							var obj = photosArray[i];
							$( "#artist-recent-photos" ).append($('#artistRecentPhotosTemplate').tmpl(obj));
						}
					}
				}
				
				$('#recentphotosloader').hide();
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}
	
	
/************ Ajax call to load artist recent videos **************/
	
	if ($('#artist-recent-videos').length) {
		$.ajax({
			url : config.baseurljs + 'profile/artist/getartistrecentvideos',
			dataType: "json",
			async : true,
			success : function(response) {
				
				if(response.status == false){
					$('#artist-recent-videos').html('Unable to load recent artist videos.');
				}
				else if(response.status == true){
					
					var videosArray = eval(response.data.galleryVideoData);
					
					if(videosArray == null){
						$( "#artist-recent-videos" ).html("No Recent Videos.");
					}
					else{
						for(var i = 0; i < videosArray.length; i++) {
							var obj = videosArray[i];
							$( "#artist-recent-videos" ).append($('#artistRecentVideosTemplate').tmpl(obj));
						}
					}
				}
				
				$('#recentvideosloader').hide();
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}

/************ Ajax call to load public profile artist review **************/
	
	if ($('#artist-testimonial-public').length) {
		
		
		var user_id = $("#user_id").val();
		
		$.ajax({
			url : config.baseurljs + 'profile/artist/getartistreviewpublic',
			dataType: "json",
			type: 'POST',
			data: {user_id:user_id},
			async : true,
			success : function(response) {
				
				if(response.status == false){
					$('#artist-review-slider-public').html('Unable to load artist reviews.');
				}
				else if(response.status == true){
					
					var reviewArray = eval(response.data.userReviewData);
					
					if(typeof(reviewArray) == 'undefined'){
						$( "#artist-review-slider-public" ).html("No Recent Reviews.");
					}
					else{
						for(var i = 0; i < reviewArray.length; i++) {
							var obj = reviewArray[i];
							$( "#artist-review-slider-public" ).prepend($('#artistReviewItemTemplate').tmpl(obj));
						}
						
						$( "div#artist-review-slider-public div:first-child").addClass( "active" );
						$('.pull-right').show();
					}
					
				}
				
				$('#testimonialloader').hide();
				
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}	
	
	
/************ Ajax call to load public profile artist recent images **************/
	
	if ($('#artist-recent-photos-public').length) {
		
		var user_id = $("#user_id").val();
		
		$.ajax({
			url : config.baseurljs + 'profile/artist/getartistrecentphotospublic',
			dataType: "json",
			type: 'POST',
			data: {user_id:user_id},	
			async : true,
			success : function(response) {
				
				if(response.status == false){
					$('#artist-recent-photos-public').html('Unable to load recent artist images.');
				}
				else if(response.status == true){
					
					var photosArray = eval(response.data.galleryImageData);
					
					if(photosArray == null){
						$( "#artist-recent-photos-public" ).html("No Recent Images.");
					}
					else{
						for(var i = 0; i < photosArray.length; i++) {
							var obj = photosArray[i];
							$( "#artist-recent-photos-public" ).append($('#artistRecentPhotosTemplate').tmpl(obj));
						}
					}
				}
				
				$('#recentphotosloader').hide();
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}
	
	
/************ Ajax call to load public profile artist recent videos **************/
	
	if ($('#artist-recent-videos-public').length) {
		
		var user_id = $("#user_id").val();
		
		$.ajax({
			url : config.baseurljs + 'profile/artist/getartistrecentvideospublic',
			dataType: "json",
			type: 'POST',
			data: {user_id:user_id},
			async : true,
			success : function(response) {
				
				if(response.status == false){
					$('#artist-recent-videos-public').html('Unable to load recent artist videos.');
				}
				else if(response.status == true){
					
					var videosArray = eval(response.data.galleryVideoData);
					
					if(videosArray == null){
						$( "#artist-recent-videos-public" ).html("No Recent Videos.");
					}
					else{
						for(var i = 0; i < videosArray.length; i++) {
							var obj = videosArray[i];
							$( "#artist-recent-videos-public" ).append($('#artistRecentVideosTemplate').tmpl(obj));
						}
					}
				}
				
				$('#recentvideosloader').hide();
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}
	
/** Add Youtube Videos form **/


$('#addvideoform').bootstrapValidator({
    
 fields: {
    	 
		 
	videourl: {
	        validators: {
	       	 notEmpty: {
	                message: 'Please enter youtube video URL.'
	            },
	         regexp: {
                    regexp: /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/,
                    message: 'Invalid Youtube video URL.'
                }   
	        }
	  
 	},
 	
	 videodescription: {
        validators: {
       	 notEmpty: {
                message: 'Please enter some description.'
            }
        }
      }
	},
  
    onSuccess: function(e) {
	  
    	$('#addvideoform').submit(function() { 
    		
    		 	var videoUrl = $('#videourl').val();
				
				var videoId = getYouTubeVideoId(videoUrl);
				
				if(videoId){
					$("#youtubevideoid").val(videoId);
				}
				else{
					alert('Invalid Youtube URL.');
					return false;
				}
				
    		 $("#uploadvideobutton").button('loading');
    		 
    			$.ajax({
    				url : $(this).attr('action'),
    				type : $(this).attr('method'),
    				data : $(this).serialize(),
    				dataType: "json",
    				success : function(response) {
    					
    					$("#uploadvideobutton").button('reset');
    					
    					if(response.status == true){
    						$( "#galleryVideoSection" ).prepend($('#newVideoTemplate').tmpl(response.data));
    						$('#addvideosmodal').modal('hide');
    					}
    					else{
    						alert(response.errorMessage);
    					}
    				},
    				error : function(request) {
    					$("#uploadvideobutton").button('reset');
    					alert("Could not send the data." + request.responseText);
    					return false;
    				}
    			});
    			
    			return false;
    		});
     
     },
     onError: function(e) {
         
     	//Placeholder for onerror function
     	
     }
 });
	

	function getYouTubeVideoId(videoUrl){
		
		var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
		
		if(videoUrl.match(p)){
			return RegExp.$1;
		}
		else{
			return false;
		}
	}	
		
		/****** Delete Gallery Videos *******/
	
		$(document).on('click', '.delete-video', function() {
			
			var videoId = $(this).children("span.video-id").text();
			
			bootbox.confirm({
			    title: 'Delete Video',
			    message: 'Are you sure you want to delete this video?',
			    buttons: {
			        'cancel': {
			            label: 'Cancel',
			            className: 'btn-default'
			        },
			        'confirm': {
			            label: 'Confirm',
			            className: 'btn-danger'
			        }
			    },
			    callback: function(result) {
			    	if(result){
			    		deleteVideo(videoId);
			    	}
			    },
			    className:'confirmmodel'
			});
		});
		
		/*********** function to delete gallery video ***************/
		
		function deleteVideo(videoId){
			
			var divObject = $('#video_' + videoId);
			
			$.ajax({
				url : config.baseurljs + 'profile/managephotos/deletegalleryvideo',
				type : 'POST',
				data: {videoId : videoId},
				dataType: "json",
				async : false,
				success : function(response) {
					
					if(response.status == true){
						$(divObject).remove();
					}
					else if((response.status == false) && (response.data.session_exist==false)){
						var url = response.data.url;
						window.location.href = url;
					}
					else{
						alert(response.errorMessage);
					}
					
				},
				error : function(request) {
					alert("Could not send the data." + request.responseText);
					return false;
				}
			});
		}
		
		/*********** function to delete venue gallery video ***************/
		
		function deleteVideo(videoId){
			
			var divObject = $('#video_' + videoId);
			
			$.ajax({
				url : config.baseurljs + 'profile/managevenuedata/deletevenuegalleryvideo',
				type : 'POST',
				data: {videoId : videoId},
				dataType: "json",
				async : false,
				success : function(response) {
					
					if(response.status == true){
						$(divObject).remove();
					}
					else if((response.status == false) && (response.data.session_exist==false)){
						var url = response.data.url;
						window.location.href = url;
					}
					else{
						alert(response.errorMessage);
					}
					
				},
				error : function(request) {
					alert("Could not send the data." + request.responseText);
					return false;
				}
			});
		}
		
		/****** Delete Venue Gallery Videos *******/
		
		$(document).on('click', '.delete-venue-video', function() {
			
			var videoId = $(this).children("span.video-id").text();
			
			bootbox.confirm({
			    title: 'Delete Video',
			    message: 'Are you sure you want to delete this video?',
			    buttons: {
			        'cancel': {
			            label: 'Cancel',
			            className: 'btn-default'
			        },
			        'confirm': {
			            label: 'Confirm',
			            className: 'btn-danger'
			        }
			    },
			    callback: function(result) {
			    	if(result){
			    		deleteVideo(videoId);
			    	}
			    },
			    className:'confirmmodel'
			});
		});
		
		
		
	/********* Cover photo ***************/
	
	// Saving Image parameters at load. 
	var coverImageTop = $("#coverimage").css("top");	
	var coverImageSrc = $("#coverimage").attr('src');
	
	
	//adjusting cover image according to the position set
	var imageTop = $("#coverimage").css("top");
	
	$('#personalinfo').imagedrag({
		position: imageTop
	}); 
	
	$("#coverimage").draggable('disable');
	
	
	$('#repositioncoverphoto').click(function(){
		
		//$("#repo-text").css('display','block');
		$("#reposition-text").show();
		$("#coverimagebuttons").css('display','block');
		$("#repositioncoverimage").css('display','block');
		$("#savecoverimage").css('display','none');
		
		$("#coverimage").draggable('enable');
		
		var imageTop = $("#coverimage").css("top");
		
		$('#personalinfo').imagedrag({
			position: imageTop
		});
		
		//makeDivDraggable('personalinfo');
		
	});
	
	function makeDivDraggable(id){
		
		$("#"+id).draggable('enable');
		
		$("#"+id).imagedrag({
			position: imageTop
		});
		
	}
	
	$('#uploadcoverphoto').click(function(){
		
		$('#uploadcoverimagebutton').click();
		
		
	});
	
	$('#canceledit').click(function(){
		$("#reposition-text").hide();
		$("#coverimagebuttons").css('display','none');
		$("#coverimage").attr('src', coverImageSrc);
		$("#coverimage").css('top', coverImageTop);
		$("#coverimage").draggable('disable');
	});
	
	
	//Edit and reposition 
	
	$('#repositioncoverimage').click(function() { 
		
		 var imageTop = $("#coverimage").css("top");
	  	 $("#repositioncoverimage").button('loading');
	  	$("#reposition-text").hide();
	  	 
	  	var data = 'imageTop=' + imageTop
		
		 $.ajax({
				url : config.baseurljs + 'profile/editprofile/repositioncoverphoto',
				type : 'POST',
				data : {imageTop:imageTop},
				dataType: "json",
				success : function(response) {
					
					$("#repositioncoverimage").button('reset');
					
					if(response.status == true){
						$("#coverimage").draggable('disable');
						$("#coverimagebuttons").css('display','none');
					}
					else{
						alert.html("Error occurred while image re-position.");
					}
				},
				error : function(request) {
					$("#savecoverimage").button('reset');
					alert("Could not send the data." + request.responseText);
					return false;
				}
			});
			
			return false;
		});
	
	/********** On upload cover image *****************/
	
$( "#uploadcoverimagebutton" ).on('change', function(){
		
		
		// get selected file
	    var oFile = $('#uploadcoverimagebutton')[0].files[0];
		
	    //Create new form to upload photo 
	    
		var form = new FormData();
		   //append files
		 var file = document.getElementById('uploadcoverimagebutton').files[0];
		  
		 if(file) { 
			  form.append('coverimage', file);
			  form.append('filename', oFile.name);
			}
		 
		 else{
			 return;
		 }
		 
		 //$('.loader').show();
		 $('.loader').fadeOut();
		 
		 $.ajax({
				url : config.baseurljs + 'profile/editprofile/selectcoverphoto',
				type :'POST',
				data : form,
				contentType: false, //must, tell jQuery not to process the data
		        processData: false,
		        async: false,
		        dataType: "json",
		        success : function(response) {
		        	$('.loader').fadeIn(1000).removeClass('hidden');
		        	
					if(response.sessionExist == false){
						customAlert('Error', response.errorMessage);
						window.location.href=response.data.base_url;
					}
					else if(response.status == true){
						$("#coverimage").attr('src', response.data.imageUrl);
						$("#reposition-text").show();
						$('#coverimagefilename').val(response.data.fileName);
						
						$("#coverimage").draggable('enable');
				        $('#personalinfo').imagedrag();
				        
				        //Show image save and cancel buttons
				        $("#coverimagebuttons").css('display','block');
						$("#repositioncoverimage").css('display','none');
						$("#savecoverimage").css('display','block');
					}
					else if(response.status == false){
						customAlert('Error', response.errorMessage);
					}
					
				},
				error : function(request) {
					$('.loader').fadeIn(1000).removeClass('hidden');
					customAlert('Error', 'Error in page. Please try after some time.');
					return false;
				}
			});
		
		});

	/********** On save cover image *****************/
	
	$( "#savecoverimage" ).on('click', function(){
	
	// get selected file
    var fileName = $('#coverimagefilename').val();
    var coverimagetop = $("#coverimage").css("top");
    $("#savecoverimage").button('loading');
    $("#reposition-text").hide();
    
    $.ajax({
			url : config.baseurljs + 'profile/editprofile/uploadcoverphoto',
			type :'POST',
			data: {fileName:fileName, coverimagetop:coverimagetop},
	        dataType: "json",
	        success : function(response) {
	        	$("#savecoverimage").button('reset');
				if(response.sessionExist == false){
					customAlert('Error', response.errorMessage);
					window.location.href=response.data.base_url;
				}
				else if(response.status == true){
					
					$('#personalinfo').imagedrag({
						'position': response.data.image_position
					});
					
					$("#coverimage").draggable('disable');
					$("#coverimagebuttons").css('display','none');
					
				}
				else if(response.status == false){
					customAlert('Error', response.errorMessage);
				}
				
			},
			error : function(request) {
				$("#savecoverimage").button('reset');
				customAlert('Error', 'Error in page. Please try after some time.');
				return false;
			}
		});
	
	});
	
	
/****** Delete Cover Image *******/
	
	$( "#deletecoverphoto" ).on('click', function(){
		
		
		bootbox.confirm({
		    
			title: 'Delete Photo',
		    message: 'Are you sure you want to delete cover photo?',
		    buttons: {
		        'cancel': {
		            label: 'Cancel',
		            className: 'btn-default'
		        },
		        'confirm': {
		            label: 'Confirm',
		            className: 'btn-danger'
		        }
		    },
		    callback: function(result) {
		    	if(result){
		    		deleteCoverImage();
		    	}
		    	
		    },
		    className:'confirmmodel'
		});
		
	});
	
	/*********** function to delete cover image ***************/
	
	function deleteCoverImage(){
		
		
		$.ajax({
			url : config.baseurljs + 'profile/managephotos/deletecoverphoto',
			dataType: "json",
			async : true,
			success : function(response) {
				
				if(response.sessionExist == false){
					customAlert('Error', response.errorMessage);
				}
				else if(response.status == true){
					$("#coverimage").attr('src', '');
				}
				else{
					customAlert('Error', response.errorMessage);
				}
				
			},
			error : function(request) {
				alert("Could not send the data." + request.responseText);
				return false;
			}
		});
	}
	
	
	
	
	/********************RATY*********************/

 /*   $('#avgscore').raty({
        readOnly: false,
        score: 3,
        path: config.baseurljs + 'images'

    });
 */   
    
       /*********************Edit profile Forms****************************/

    /*******************EDITABLE****************************/
    //turn to inline mode
    $.fn.editable.defaults.mode = 'inline';
    var editedForm = [];
    // alert(CategoriesforJS);
    $('#editfirstname').editable({
        type: "text",
        title: "Enter firstname",
        validate: function(value) {
            if ($.trim(value) == '') {
                return 'First name is required and cannot be empty.';
            }
            if (/^[a-z\s]+$/i.test(value) == false) {
                return  'The First name can consist of alphabetical characters only.';
            }
        },
        success: function(response, newValue) {
            editedForm[0] = newValue;
        }
    });
    $('#editlastname').editable({
        type: "text",
        title: "Enter lastname",
        validate: function(value) {
            if ($.trim(value) == '') {
                return 'Last name is required and cannot be empty.';
            }
            if (/^[a-z\s]+$/i.test(value) == false) {
                return 'The Last name can consist of alphabetical characters only.';
            }

        },
        success: function(response, newValue) {
            editedForm[1] = newValue;
        }
    });
    $('#editmobile').editable({
        type: "text",
        title: "Enter Phone Number",
        validate: function(value) {
            if ($.trim(value) == '') {
                return 'Mobile Number is required and cannot be empty.';
            }
            if (/^[9 8 7]\d{9}$/.test(value) == false) {
                return 'Not a valid mobile number';
            }

        },
        success: function(response, newValue) {
            editedForm[2] = newValue;
        }

    });

    $('#editcategory').editable({
        type: "select",
        title: "Select a category",
        source: CategoriesforJS,
        validate: function(value) {
            if ($.trim(value) === '') {
                return '"Type of Artist" can not be left blank.';
            }

        },
        success: function(response, newValue) {
            editedForm[3] = newValue;
            loadSubCategories(subCategories, newValue);
        }
    });
    $('#editcategory').on('save', function(e, params) {
        $('#editsubcategory').trigger('click');
    });
    $('#editsubcategory').editable({
        type: "select",
        title: "Select a sub-category",
        source: function() {
            return subCategoriesforJS;
        },
        validate: function(value) {
            if ($.trim(value) == '') {
                return '"Speciality" can not be left blank.';
            }

        },
        success: function(response, newValue) {
            editedForm[4] = newValue;
        }
    });
    $('#editfblink').editable({
        type: "text",
        title: "Enter firstname",
        success: function(response, newValue) {
            editedForm[5] = newValue;
        }
    });
    $('#edittwitterlink').editable({
        type: "text",
        title: "Enter lastname",
        success: function(response, newValue) {
            editedForm[6] = newValue;
        }
    });
    $('#updateprofilebutton').click(function() {

        $.ajax({
            url: config.baseurljs + 'profile/editprofile/updateprofile',
            type: 'POST',
            data: {
                firstname: editedForm[0] || currentvalues.firstname,
                lastname: editedForm[1] || currentvalues.lastname,
                mobile: editedForm[2] || currentvalues.mobile,
                category: editedForm[3] || currentvalues.category,
                subcategory: editedForm[4] || currentvalues.subcategory,
                categoryName: document.getElementById('editcategory').innerHTML,
                subcategoryName: document.getElementById('editsubcategory').innerHTML
            },
            dataType: "json",
            success: function(response) {

                location.href = config.baseurljs+'profile/artist/edit#tab_a';
                location.reload(); 

            },
            error: function(request) {

                bootbox.alert("There seems to be some issue with the network connectivity. Please try again later!!");


            }
        });

        return false;
    });

    $('#updateLinksButton').click(function() {

        $.ajax({
            url: config.baseurljs + 'profile/editprofile/updatelinks',
            type: 'POST',
            data: {
                fblink: editedForm[5] || currentvalues.editfblink,
                twitterlink: editedForm[6] || currentvalues.edittwitterlink,
            },
            dataType: "json",
            success: function(response) {

                location.href = config.baseurljs+'profile/artist/edit#tab_b';
                location.reload(); 

            },
            error: function(request) {

                bootbox.alert("There seems to be some issue with the network connectivity. Please try again later!!");


            }
        });

        return false;
    });



    $('#updatePassword').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            crntpassword: {
                validators: {
                    notEmpty: {
                        message: 'The "Current password" field is required and cannot be empty'
                    }
                }
            },
            newpassword: {
                validators: {
                    notEmpty: {
                        message: 'The "New Password" field is required and cannot be empty'
                    },
                    stringLength: {
                        min: 8,
                        max: 30,
                        message: 'The password must be more than 8 and less than 30 characters long'
                    }
                }
            },
            cnfpassword: {
                validators: {
                    notEmpty: {
                        message: 'The "Confirm Password" field is required and cannot be empty'
                    },
                    identical: {
                        field: 'newpassword',
                        message: 'The password and its confirm must be the same'
                    }
                }
            }
        },
        button: {
            selector: '[type="submit"]',
            disabled: ''
        },
        onSuccess: function(e) {


            $('#updatePassword').submit(function() {

                $("#updatepassbuton").button('loading');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {

                        $("#updatepassbuton").button('reset');

                        if (response.status == false) {
                            $('.update_error_message').html(response.errorMessage);
                            $('.update_error_message').css("display", "block");
                            $('.update_error_message').css("color", "red");
                        }

                        else {

                            // window.location.href = "signup/signupconfirm";*/
                            $('.update_error_message').html(response.errorMessage);
                            $('.update_error_message').css("display", "block");
                            $('.update_error_message').css("color", "green");

                        }
                    },
                    error: function(request) {
                        bootbox.alert("There seems to be some issue with the network connectivity. Please try again later!!");
                        return false;
                    }
                });

                return false;
            });

        },
        onError: function(e) {

            //Placeholder for onerror function

        }
    });

    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-pills a[href=#' + url.split('#')[1] + ']').tab('show');
    }
    // Change hash for page-reload
    $('.nav-pills a').on('shown', function(e) {
        window.location.hash = e.target.hash;
    }) 
      
    
    
});

/************ Google APIs ****************/

function onSignInCallbackAfterReview(resp) {
	gapi.client.load('plus', 'v1', apiClientLoadedForReview);
  }

  /**
   * Sets up an API call after the Google API client loads.
   */
  function apiClientLoadedForReview() {
    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponseForReview);
  }

  /**
   * Response callback for when the API client receives a response.
   *
   * @param resp The API response object with the user email and profile information.
   */
  function handleEmailResponseForReview(resp) {
    var email;
    var firstName;
    var lastName;
    
    for (var i=0; i < resp.emails.length; i++) {
      if (resp.emails[i].type === 'account'){ 
    	  email = resp.emails[i].value;
    	  firstName = resp.name.givenName;
    	  lastName = resp.name.familyName;
    	  
    	  loginUserWithGoogleForReview(email, firstName, lastName);
    	}
      }
  }

  function loginUserWithGoogleForReview(email, firstName, lastName){
		
		 console.log('Welcome!  Fetching your information from Google.... ');
		 		
		        var argsString = 'email=' + email;
		        
		        $.ajax({
		   			url : config.baseurljs + 'login/loginform/loginWithSocialNetworkForReview',
		   			type : 'POST',
		   			data : argsString,
		   			dataType: "json",
		   			success : function(response) {
		   				
		   				if((response.status == true) && (response.data.email != '')){	
		   					
		   					$("#reviewer_email").val(response.data.email);
		   					$('#reviewform').attr("action", config.baseurljs + 'profile/artistreview/addartistreviewfromguest');
		   					$('#reviewform').submit();
		   					$('#reviewLoginModal').modal('toggle');
		   					
		   				}
		   				else{
		   					$('.login_error_message').html(response.errorMessage);
		       				$('.login_error_message').css("display", "block");
		   				}
		   				
		   			},
		   			error : function(request) {
		   				alert("Could not send the data." + request.responseText);
		   				return false;
		   			}
		   		});
	
  }
  



    /********************imageupload*********************/

var thumb = $("#edit-profile-image");
$('#save_thumb').click(function() {
	var x1 = $('#x1').val();
	var y1 = $('#y1').val();
	var x2 = $('#x2').val();
	var y2 = $('#y2').val();
	var w = $('#w').val();
	var h = $('#h').val();
	if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
		alert("You must make a selection first");
		return false;
	}
});

function preview(img, selection)
{
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}




/********** Add Artist Rating *************/


/**********to load category and sub category req for ditable form **********/
var subCategoriesforJS;
var CategoriesforJS;
var subCategories;
function loadSubCategories(sub_categories, category_id) {

    subCategories = sub_categories;
    temp = eval(subCategories);
    subCategoriesforJS = "[";
    for (var i = 0; i < temp.length; i++) {

        if (temp[i][0] == category_id) {
            subCategoriesforJS += "{ value :'" + temp[i][1] + "',text:'" + temp[i][2] + "'},";
        }
    }
    subCategoriesforJS = subCategoriesforJS.substring(0, subCategoriesforJS.length - 1);
    subCategoriesforJS += "]";

}
function loadCategories(categories) {
    temp = eval(categories);
    CategoriesforJS = "[";
    for (var i = 0; i < temp.length; i++) {
        CategoriesforJS += "{ value :'" + temp[i][0] + "',text:'" + temp[i][1] + "'},";
    }
    CategoriesforJS = CategoriesforJS.substring(0, CategoriesforJS.length - 1);
    CategoriesforJS += "]";

}

function customAlert(messageTitle, message){
	bootbox.alert({
	    title: messageTitle,
	    message: message,
	    className:'alertmodel'
	});
}



