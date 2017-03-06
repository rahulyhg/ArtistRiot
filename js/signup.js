$(document).ready(function() {


	 $('#signupform').bootstrapValidator({
         
		 feedbackIcons: {
             valid: 'glyphicon glyphicon-ok',
             invalid: 'glyphicon glyphicon-remove',
             validating: 'glyphicon glyphicon-refresh'
         },
         
		 fields: {
        	 firstname: {
                 validators: {
                     notEmpty: {
                         message: 'First name is required and cannot be empty'
                     },
                     regexp: {
                         regexp: /^[a-z\s]+$/i,
                         message: 'The First Name can consist of alphabetical characters only.'
                     }
                 }
             },
             lastname: {
                 validators: {
                     notEmpty: {
                         message: 'Lastname is required and cannot be empty'
                     },
                     regexp: {
                         regexp: /^[a-z\s]+$/i,
                         message: 'The Last Name can consist of alphabetical characters only.'
                     }
                 }
             },
             venue_name: {
                 validators: {
                     notEmpty: {
                         message: 'Venue name is required and cannot be empty'
                     }
                 }
             },
             password: {
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
             
             signup_email: {
                 validators: {
                     notEmpty: {
                         message: 'Email is required and cannot be empty'
                     }
                 }
             },
             signup_email_confirm: {
                 validators: {
                     notEmpty: {
                         message: 'The confirm email is required and cannot be empty'
                     },
                     identical: {
                         field: 'signup_email',
                         message: 'The email and its confirm must be the same'
                     }
                 }
             },
             mobile: {
                 validators: {
                	 notEmpty: {
                         message: 'Mobile number is required and cannot be empty.'
                     },
                     digits: {
                    	 message: 'Only digits are allowed in mobile number.'
                     },
                	 regexp: {
                    	 regexp: /^[9 8 7]\d{9}$/,
                         message: 'Mobile number should be of 10 digits only.'
                     }
                     
                 }
             },
             
             
         },
         onSuccess: function(e) {
             
         	
         	$('#signupform').submit(function() { 
         		
         		$("#sigupbutton").button('loading');
         		
         		$.ajax({
         			url : $(this).attr('action'),
         			type : $(this).attr('method'),
         			data : $(this).serialize(),
         			dataType: "json",
         			success : function(response) {
         				
         				$("#sigupbutton").button('reset');
         				
         				if(response.status == false){
         					customAlert('Invalid data', response.errorMessage);
         				}
         				
         				else{
         					window.location.href="signup/signupconfirm";
         				}
         			},
         			error : function(request) {
         				customAlert('Error', 'Error in sending data.');
         				//alert("Could not send the data." + request.responseText);
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
	 
	 /******** On venue change dropdown *********/
	 
	 $('#user_role').on('change', function() {
		 
		
		 if(this.value == 'venue'){
			 $("#firstnamediv").hide();
			 $("#lastnamediv").hide();
			 $("#genderdiv").hide();
			 $("#venuenamediv").show();
		}
		 else{
			 $("#firstnamediv").show();
			 $("#lastnamediv").show();
			 $("#genderdiv").show();
			 $("#venuenamediv").hide();
		 }
		
	 });
	
	 //Select categories default
	 
	// $('#artist_category').empty().append('<option selected disabled value="">Please select a Category</option>');
	 $('#artist_category option[value="-1"]').attr('selected','selected');
	 
	 /************ Loading google API *****************/

		//google.maps.event.addDomListener(window, 'load', initialize);
		 
		 var cityObj = document.getElementById('city');
		 var options = {  types: ['(cities)'],  componentRestrictions: {country: 'in'}};

	     new google.maps.places.Autocomplete(cityObj, options);
	     
	     
	/************ Loading google API end *****************/     
	
	/* Making category dropdown multiselect*/
	     
	var venueCategoriesArray = [];     
	$('#events_category').multiselect({
		onChange: function(element, checked) {
	        var categories = $('#events_category option:selected');
	        var selected = [];
	        $(categories).each(function(index, category){
	        	venueCategoriesArray.push([$(this).val()]);
	        });

	    }
	});

	 
	 //Multi-step form validations:
	 
	$('#artistprofileform').bootstrapValidator({
         
	/*	 feedbackIcons: {
             valid: 'glyphicon glyphicon-ok',
             invalid: 'glyphicon glyphicon-remove',
             validating: 'glyphicon glyphicon-refresh'
         },
    */     
		 fields: {
        	 
			 artist_category: {
                 validators: {
                	 notEmpty: {
                         message: 'Please select the type of Artist.'
                     }
                 }
             },
             
             artist_sub_category: {
                 validators: {
                	 notEmpty: {
                         message: 'Please select the speciality of Artist.'
                     }
                 }
             },
			 
           gender: {
                 validators: {
                	 notEmpty: {
                         message: 'Please select gender.'
                     }
                 }
             },
             
             description: {
                 validators: {
                	 notEmpty: {
                         message: 'Please enter some description.'
                     },
                     stringLength: {
                         min: 50,
                         message: 'Description must be of atleast 50 characters.'
                     }
                 }
             },
             venue_description:{
            	 validators: {
                	 notEmpty: {
                         message: 'Please enter some description.'
                     },
                     stringLength: {
                         min: 50,
                         message: 'Description must be of atleast 50 characters.'
                     }
                 }
             },
             events_category: {
            	 excluded: 'false',
             	 validators: {
                	 notEmpty: {
                         message: 'Please select events for venue.'
                     }
                 }
             },
             city: {
                 validators: {
                	 notEmpty: {
                         message: 'Please select city.'
                     }
                 }
             }
             
         },
         onSuccess: function(e) {
             
         	$('#artistprofileform').submit(function() { 
         		
         		$("#artistprofilebutton").button('loading');
         		
         		var events_category = getVenueCategories();
         		var city = $('#city').val();
         		var venue_description = $('#venue_description').val();
         		var artist_category = $('#artist_category').val();
         		var artist_sub_category = $('#artist_sub_category').val();
         		var description = $('#description').val();
         		var gender = $("#genderdiv input[type='radio']:checked").val();
         		
         		$.ajax({
         			url : $(this).attr('action'),
         			type : $(this).attr('method'),
         			//data : $(this).serialize(),
         			data : {events_category:events_category,city:city,venue_description:venue_description, artist_category:artist_category,
         				artist_sub_category:artist_sub_category,description:description,gender:gender},
         			dataType: "json",
         			success : function(response) {
         				
         				$("#artistprofilebutton").button('reset');
         				
         				//Validate session
         				if(response.sessionExist == false){
         					window.location.href=response.data.base_url;
         				}
         				//No error
         				else if(response.status == true){
         					document.getElementById("first").style.display="none";
         					document.getElementById("second").style.display="block";
         					document.getElementById("active2").style.color="red";
         					//window.location.href="signup/signupconfirm";
         					nextclick();
         				}
         				//Error occured
         				else if((response.status == false) && response.errorMessage != ''){
         					$('.signup_error_message').html(response.errorMessage);
         					$('.signup_error_message').css("display", "block");
         				}
         				
         			},
         			error : function(request) {
         				$("#artistprofilebutton").button('reset');
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

	function getVenueCategories(){
		
		var categories = $('#events_category option:selected');
        var selected = [];
        $(categories).each(function(index, category){
        	selected.push([$(this).val()]);
        });
        
        return selected.toString();
        
	}

$('#socialmediaform').submit(function() { 
		
		$("#socialmediabutton").button('loading');
		
		$.ajax({
			url : $(this).attr('action'),
			type : $(this).attr('method'),
			data : $(this).serialize(),
			dataType: "json",
			success : function(response) {
				
				$("#socialmediabutton").button('reset');
				
				//Validate session
 				if(response.sessionExist == false){
 					window.location.href=response.data.base_url;
 				}
 				
 				else if(response.status == false){
					customAlert('Error', response.errorMessage);
 				}
				
				else {
					
					 document.getElementById("second").style.display="none";
					 document.getElementById("third").style.display="block";
					 document.getElementById("active3").style.color="red";
					 
					 var ias = $('#profile-image').imgAreaSelect({ 
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
					//window.location.href="signup/signupconfirm";
					nextclick();
				}
			},
			error : function(request) {
				customAlert('Error', 'Something wrong here. Please try after some time.');
				return false;
			}
		});
		
		return false;
	});

	

	// Profile creation

$('#createprofilebutton').click(function(){
	
	 $("#createprofilebutton").button('loading');
	 
	 $.ajax({
		url : 'http://artistriot.com/artistriot/login/signup/createuserprofile',
		type : 'POST',
		dataType: "json",
		success : function(response) {
			
			$("#createprofilebutton").button('reset');
			
			//Validate session
			if(response.sessionExist == false){
				window.location.href=response.data.base_url;
			}
			else if(response.status == true){
				//alert('profile created.');
				window.location.href=response.data.profileUrl;
			}
			else if(response.status == false){
				customAlert('Error', response.errorMessage);
			}
		},
		error : function(request) {
			$("#createprofilebutton").button('reset');
			customAlert('Error', 'Something wrong here. Please try after some time.');
		}
	});
		
});


	function nextclick(){
		$('.signup_error_message').css("display", "none");
		$(this).parent().next().fadeIn('slow');
		$(this).parent().css({
		//'display': 'none'
		});
		// Adding Class Active To Show Steps Forward;
		$('.active').next().addClass('active');
	}
	
	$(".pre_btn").click(function() { // Function Runs On PREVIOUS Button Click
		
		$(this).parent().prev().fadeIn('slow');
		$(this).parent().css({
		//'display': 'none'
		});
		// Removing Class Active To Show Steps Backward;
		$('.active:last').removeClass('active');
		
	});
	
	
	var left = 500;
	   
    $('#text_counter').text('Characters left: ' + left);

        $('#description').keyup(function (e) {

        left = 500 - $(this).val().length;

        if(left < 0){
            $('#text_counter').addClass("overlimit");
            e.preventDefault(); 
        }else{
            $('#text_counter').removeClass("overlimit");
            
        }

        $('#text_counter').text('Characters left: ' + left);
    });

    

});


	$('#artist_category').on('change', function() {
		 
		 $('#artist_sub_category').empty().append('<option selected disabled value="">Please select Sub Categories</option>');
		 
		 //var argsString = 'category_id=' + this.value;
		  
		 for(var i=0; i < subCategories.length; i++){
			 
			 if(subCategories[i][0] == this.value.trim()){
				 $("#artist_sub_category").append(new Option(subCategories[i][2], subCategories[i][1]));
			 }
		 }
		
	 });



//Function that executes on click of first previous button
	function prev_step1(){
		
	 document.getElementById("first").style.display="block";
	 document.getElementById("second").style.display="none";
	 document.getElementById("active1").style.color="red";
	 document.getElementById("active2").style.color="gray";
	 
	}


	//Function that executes on click of second previous button
	 function prev_step2(){
	 document.getElementById("third").style.display="none";
	 document.getElementById("second").style.display="block";
	 document.getElementById("active2").style.color="red";
	 document.getElementById("active3").style.color="gray";
	 
	 
	 $('#profile-image').imgAreaSelect({ 
			show:false,
		 	hide: true
	 });
	
	}


//Fetching sub categories on page load	 
	 
var subCategories;
	 
 function getSubCategories(sub_categories){
		 subCategories = eval(sub_categories);
 }


function customAlert(messageTitle, message){
	bootbox.alert({
	    title: messageTitle,
	    message: message,
	    className:'alertmodel'
	});
}