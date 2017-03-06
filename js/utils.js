$(document).ready(function() {
	
	// Forward to user profile if user is in session
	
	var forgotpassworddisplay = false;
	
	$('#loginformpop').bootstrapValidator({
        
        fields: {
       	    
        	feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            
        	login_email: {
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
        	
        	
        	$('#loginformpop').submit(function() { 
        		
        		$('#loginpageloader').show();
        		
        		$("#loginformbutton").button('loading');
        		$.ajax({
        			url : $(this).attr('action'),
        			type : 'POST',
        			data : $(this).serialize(),
        			dataType: "json",
        			success : function(response) {
        				
        				$("#loginformbutton").button('reset');
        				$("#loginformbutton").removeAttr('disabled');
        				
        				if(response.status == true){
        					window.location.href=response.data.profileUrl;
        				}
        				else if((response.status == false) && (response.errorMessage === 'profile not created')){
        					$('#loginpageloader').hide();
        					window.location.href=response.data.profileCreateUrl;
        				}
        				else{	
        					$('#loginpageloader').hide();
        					$('.login_error_message').html(response.errorMessage);
            				$('.login_error_message').css("display", "block");
        				}
        			},
        			error : function(request) {
        				$('#loginpageloader').hide();
        				$("#loginformbutton").button('reset');
        				$("#loginformbutton").removeAttr('disabled');
        				customAlert("Could not send the data." + request.responseText);
        				return false;
        			}
        		});
        		
        		return false;
        	});
        
        },
        onError: function(e) {
      }
    });
	
	/*************** Reset Password Validation **********************/
	
$('#resetpasswordform').bootstrapValidator({
        
        fields: {
        	
        	new_password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    stringLength: {
                   	 min: 8,
                   	 max: 30,
                   	 message: 'The password must be more than 8 and less than 30 characters long'
                   	 }
                }
            },
            new_password_confirm: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    stringLength: {
                   	 min: 8,
                   	 max: 30,
                   	 message: 'The password must be more than 8 and less than 30 characters long'
                   	 },
                   	identical: {
                        field: 'new_password',
                        message: 'Cnfirm password is not matching.'
                    }
                }
            }
        }
    });
	
	
	/************** Forgot password validators *********************/
	
	$('#forgotpasswordform').bootstrapValidator({
        
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
        	$('#forgotpasswordform').submit(function() { 
        		
        		var email = getValue('forgot_password_email').trim();
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
        				customAlert("Could not send the data." + request.responseText);
        			}
        		});
        		
        		return false;
        	});
        }
    });

$('#logintabs li:eq(0) a').click(function(e){
    
	$('.login_error_message').html("");
	$('.login_error_message').css("display", "none");
	$('#forget_password_section').css("display", "none");
	$('.forgot_password_error_message').css("display", "none");
	$('#forgot_password_email').val("");
	
});

$('#login').on('hidden.bs.modal', function () {
	
	$('.login_error_message').html("");
	$('.login_error_message').css("display", "none");
	$('#forget_password_section').css("display", "none");
	$('.forgot_password_error_message').css("display", "none");
	$('#forgot_password_email').val("");
})

$('#forget_password_link').click(function(){
	
	
	if(forgotpassworddisplay == false){
		$('#forget_password_section').css("display", "block");
		forgotpassworddisplay = true;
	}
	else if(forgotpassworddisplay == true){
		$('#forget_password_section').css("display", "none");
		$('.forgot_password_error_message').css("display", "none");
		$('#forgot_password_email').val("");
		forgotpassworddisplay = false;
	}
		
});

// Forgot password functions:

function sendemail(){

	var email = getValue('forgot_password_email').trim();
	
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
			customAlert("Could not send the data." + request.responseText);
			
		}
	});
}

/************************ Social network login functions ******************************/

/*
$.ajaxSetup({ cache: true });
$.getScript('//connect.facebook.net/en_UK/all.js', function(){
  FB.init({
	  appId: '1427059004241068',
	  status: true,
      cookie: true // enable cookies to allow the server to access 
});
}); 

*/

$("#fb-login").on("click", function() {
	
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
	        
	        var argsString = 'login_email=' + email + '&first_name=' + first_name + '&last_name=' + last_name + '&access_token=' + fbAccessToken + '&user_role=' + user_role;
	        
	        $.ajax({
    			url : config.baseurljs + 'login/loginform/loginWithSocialNetwork',
    			type : 'POST',
    			data : argsString,
    			dataType: "json",
    			success : function(response) {
    				
    				
    				if(response.status == true){
    					window.location.href= response.data.profileUrl;
    				}
    				else if((response.status == false) && (response.errorMessage == 'profile not created')){	
    					window.location.href= response.data.gettingStartedUrl;
    				}
    				else{
    					$('.login_error_message').html(response.errorMessage);
        				$('.login_error_message').css("display", "block");
    				}
    				
    			},
    			error : function(request) {
    				customAlert("Could not send the data." + request.responseText);
    				return false;
    			}
    		});
	        
	    });
}


/************************ Google login ******************************/
$("#google-login").on("click", function() {

    var po = document.createElement('script');
    po.type = 'text/javascript';
    po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
});




/*********************************SLICK CAROUSAL************************/
//Not in scope of phase one
/*
    $('.slider-for1').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav1'
    });
    $('.slider-nav1').slick({
        asNavFor: '.slider-for1',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '10px',
        slidesToShow: 3,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });


    $('.slider-for2').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav2'
    });
    $('.slider-nav2').slick({
        asNavFor: '.slider-for2',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '10px',
        slidesToShow: 3,
      //  autoplay: true,
      //  autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });


    $('.slider-for3').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav3'
    });
    $('.slider-nav3').slick({
        asNavFor: '.slider-for3',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '10px',
        slidesToShow: 3,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    }); */
    /*********************************SLICK CAROUSAL************************/
});

/************ Google APIs ****************/

function onSignInCallback(resp) {
    gapi.client.load('plus', 'v1', apiClientLoaded);
  }

  /**
   * Sets up an API call after the Google API client loads.
   */
  function apiClientLoaded() {
    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
  }

  /**
   * Response callback for when the API client receives a response.
   *
   * @param resp The API response object with the user email and profile information.
   */
  function handleEmailResponse(resp) {
    var email;
    var firstName;
    var lastName;
    
    for (var i=0; i < resp.emails.length; i++) {
      if (resp.emails[i].type === 'account'){ 
    	  email = resp.emails[i].value;
    	  firstName = resp.name.givenName;
    	  lastName = resp.name.familyName;
    	  
    	  loginUserWithGoogle(email, firstName, lastName);
    	}
      }
  }

  function loginUserWithGoogle(email, firstName, lastName){
		
		 console.log('Welcome!  Fetching your information from Google.... ');
		 		var user_role = $('#user_role').val();
		        var argsString = 'login_email=' + email + '&first_name=' + firstName + '&last_name=' + lastName + '&user_role=' + user_role;
		        
		        $.ajax({
	    			url : config.baseurljs + 'login/loginform/loginWithSocialNetwork',
	    			type : 'POST',
	    			data : argsString,
	    			dataType: "json",
	    			success : function(response) {
	    				
	    				if(response.status == true){
	    					window.location.href= response.data.profileUrl;
	    				}
	    				else if((response.status == false) && (response.errorMessage == 'profile not created')){	
	    					window.location.href= response.data.gettingStartedUrl;
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

function setArtistRole(){
	
	$("#user_role").val("artist");
	$("#accountType").html("Artist");

}

function setVenueRole(){
	
	$("#user_role").val("venue");
	$("#accountType").html("Venue");
}

function getValue(id) {
	var value = '';
	if (document.getElementById(id) != null){
		value = document.getElementById(id).value;
	}
	return value;
}

function customAlert(message){
	bootbox.alert({
	    title: 'Error',
	    message: message,
	    className:'alertmodel'
	});
}

