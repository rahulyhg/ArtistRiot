$(document).ready(function(){
	
	//Image upload button
	$('#selectfilebutton').click(function(){
		$('#profileimageupload').click();
	});
		
		$("#changeimagebutton").click(function(){
			
			bootbox.confirm({
			    title: 'Change Photo',
			    message: 'Are you sure you want to change your current profile photo? Your current photo will be deleted.',
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
			    		$('#profileimageupload').click();
			    	}
			    },
			    className:'confirmmodel'
			});
		});

	
	/*** new logic ***/
	
	$('#profile-image').imgAreaSelect({ 
		onSelectChange: preview
	});
	
	$( "#profileimageupload" ).on('change', function(){
		
		
		// get selected file
	    var oFile = $('#profileimageupload')[0].files[0];
		
	    //Create new form to upload photo 
	    
		var form = new FormData();
		   //append files
		 var file = document.getElementById('profileimageupload').files[0];
		  
		 if(file) { 
			  form.append('profileimage', file);
			  form.append('filename', oFile.name);
			}
		 
		 else{
			 return;
		 }
		 
		 //Setting image area 
		 
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
			ias.update();
			
			ias.setSelection(75, 75, 225, 225, true);
			ias.update();
		
		 
		 $.ajax({
				url : config.baseurljs + 'login/signup/profileimageupload',
				type :'POST',
				data : form,
				contentType: false, //must, tell jQuery not to process the data
		        processData: false,
		        async: false,
		        dataType: "json",
		        success : function(response) {
					
					if(response.sessionExist == false){
						customAlert('Error', response.errorMessage);
						window.location.href=response.data.base_url;
					}
					else if(response.status == true){
						$('#profile-image').attr('src', response.data.imageUrl);
						$('.imagesavebuttons').show();
						$('#selectfilebutton').hide();
						$('#changeimagebutton').hide();
						
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
		
		});
		
	$('#profile-image').on('load', function () {
			
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
			
			return true;
			
		});
	
	$('#cancelupload').click(function(){
		
		$("#cancelupload").button('loading');
		
		$.ajax({
			url : config.baseurljs + 'login/signup/cancelimageupload',
			type : 'POST',
			data : '',
			dataType: "json",
	        success : function(response) {
				
				if(response.sessionExist == false){
					customAlert('Error', response.errorMessage);
					window.location.href=response.data.base_url;
				}
				else if(response.status == true){
					$('#profile-image').attr('src', config.baseurljs + 'images/avatar.png');
					$('#selectfilebutton').css('display','block');
					$('.imagesavebuttons').css('display','none');
				}
				else if(response.status == false){
					customAlert('Error', response.errorMessage);
				}
				
				$("#cancelupload").button('reset');
				
			},
			error : function(request) {
				customAlert('Error', 'Error in page. Please try after some time.');
				return false;
			}
		});
	});
	
$('#imageuploadbutton').click(function(){
		
	
		$("#imageuploadbutton").button('loading');
		
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var w = $('#w').val();
		var h = $('#h').val();
		
		$.ajax({
			url : config.baseurljs + 'login/signup/cropandsaveimage',
			type : 'POST',
			data : {x1:x1, y1:y1, w:w, h:h},
			dataType: "json",
	        success : function(response) {
				
				if(response.sessionExist == false){
					customAlert('Error', response.errorMessage);
					window.location.href=response.data.base_url;
				}
				else if(response.status == true){
					
					$('.imagesavebuttons').css('display','none');
					$("#changeimagebutton").css('display','block');
					
					customAlert('Success', 'Profile image uploaded successfully.');
				}
				else if(response.status == false){
					customAlert('Error', response.errorMessage);
				}
				
				$("#imageuploadbutton").button('reset');
				
			},
			error : function(request) {
				customAlert('Error', 'Error in page. Please try after some time.');
				$("#imageuploadbutton").button('reset');
				return false;
			}
		});
		return false;
	});

	
});

function customAlert(messageTitle, message){
	bootbox.alert({
	    title: messageTitle,
	    message: message,
	    className:'alertmodel'
	});
}

function preview(img, selection)
{
	
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
	
}





