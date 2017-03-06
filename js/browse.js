$(document).ready(function() {
	
	
	$( "#slider-range" ).slider({
	      range: true,
	      min: 5000,
	      max: 100000,
	      values: [ 5000, 100000 ],
	      slide: function( event, ui ) {
	        $( "#amount" ).html( '<i class="fa fa-rupee"></i> ' + ui.values[ 0 ] + ' - <i class="fa fa-rupee"></i> ' + ui.values[ 1 ] );
	        
	      },
		  stop: function(event, ui){
			  var mi = ui.values[ 0 ];
	          var mx = ui.values[ 1 ];
	          filterResults(mi, mx);
		  }
	    });
	
	function filterResults(mi, mx){
		
		$( ".browse-tile" ).each(function( index ) {
			var rating =  $(this).find(".rating").text();
			
			if(rating > 3){
				$(this).hide();
			}
		});
	}
	
	
	
	/*** Get artist sub-categories n browse page. ***/
	$('#artist_category_browse').on('change', function() {
		 
		 $('#artist_sub_category_browse').empty().append('<option selected disabled value="">Please select Sub Categories</option>');
		 
		 for(var i=0; i < subCategories.length; i++){
			 if(subCategories[i][0] == this.value.trim()){
				 $("#artist_sub_category_browse").append(new Option(subCategories[i][2], subCategories[i][1]));
			 }
		 }
		
	 });
	
	
	
	$('#browseartist').click(function(){
		
		$("#browseartist").button('loading');
		$( ".browse-result" ).remove();
		$( ".browse-tile" ).remove();
		$('#browseresultsloader').show();
		
		var categoryId = $('#artist_category_browse').val();
		var subCategoryId = $('#artist_sub_category_browse').val();
		var city = $('#location').val();
		
		var categoryName = $('#artist_category_browse option:selected:not([disabled])').text();
		var subCategoryName = $('#artist_sub_category_browse option:selected:not([disabled])').text();
		
		
		var pageurl = config.baseurljs + 'browse';
		
		if(categoryName != ''){
			pageurl = pageurl + '/category/' + categoryName;
		}
		
		if(subCategoryName != ''){
			pageurl = pageurl + '/genre/' + subCategoryName;
		}
		
		if(city != ''){
			pageurl = pageurl + '/city/' + city;
		}
		
		window.history.pushState({path:pageurl},'',pageurl);
		
		$.ajax({
			url : config.baseurljs + 'browse/browseartist/browseresults',
			type : 'POST',
			data : {categoryId:categoryId,subCategoryId:subCategoryId, city:city},
			dataType: "json",
			success : function(response) {
				
				$('#browseresultsloader').hide();
				
	        	$("#browseartist").button('reset');
	        	
				if(response.status == true){
					if(response.data != ''){
						var searchDataArray = eval(response.data.searchData);
						
						for(var i = 0; i < searchDataArray.length; i++) {
							var obj = searchDataArray[i];
							$( "#browseResultsSection" ).append($('#searchResultTemplate').tmpl(obj));
						}
						
						if(searchDataArray.length <= 10){
	            			loadMore = false;
	            		}
					}
					else{
						$( "#browseResultsSection" ).append($('#blankResultTemplate').tmpl());
						loadMore = false;
					}
					
				}
				
				else if(response.status == false){
					loadMore = false;
					customAlert('Error', response.errorMessage);
				}
			},
			error : function(request) {
				$('#browseresultsloader').hide();
				customAlert('Error', 'Error in page. Please try after some time.');
				$("#browseartist").button('reset');
				return false;
			}
		});
		
	});
	
	
/************* Load more artist *****************/
	
function loadMoreArtists(){
	
	var categoryId = $('#artist_category_browse').val();
	var subCategoryId = $('#artist_sub_category_browse').val();
	var city = $('#location').val();
	
	$.ajax({
		url : config.baseurljs + 'browse/browseartist/loadmorebrowseresults',
		type : 'POST',
		data : {categoryId:categoryId,subCategoryId:subCategoryId, city:city, offset:offset},
		async: false,
		dataType: "json",
		success : function(response) {
			
			if(response.status == true){
				
				if(response.data != ''){
					
					var searchDataArray = eval(response.data.searchData);
					
					offset = offset + searchDataArray.length;
					
					for(var i = 0; i < searchDataArray.length; i++) {
						var obj = searchDataArray[i];
						$( "#browseResultsSection" ).append($('#searchResultTemplate').tmpl(obj));
					}
					
					$(".loader_image").hide();
					
					if(searchDataArray.length <= maxResultsPerPage){
            			loadMore = false;
            		}
				}
				else{
					loadMore = false;
				}
				
			}
			
			else if(response.status == false){
				customAlert('Error', response.errorMessage);
			}
		},
		error : function(request) {
			$(".loader_image").hide();
			customAlert('Error', 'Error in page. Please try after some time.');
			return false;
		}
	});
}	
	
var loadMore = true;
var offset = 10;
var maxResultsPerPage = 10;
	

if ($('#browseArtistContainer').length) {
	
	$(window).scroll(function(){ /* window on scroll run the function using jquery and ajax */
	       var WindowHeight = $(window).height(); /* get the window height */
	       if($(window).scrollTop() + 200 >= $(document).height() - WindowHeight){ /* check is that user scrolls down to the bottom of the page */
	           /* display the loading content */
	           if(loadMore == true){
	        	   $(".loader_image").show();
	        	   loadMoreArtists();
	           }
	           else{
	        	   $(".loader_image").hide();
	           }
	           
	           return false;
	       }
	       return false;
	 });
}




/************ Loading google API *****************/

//google.maps.event.addDomListener(window, 'load', initialize);
 
 var cityObj = document.getElementById('location');
 var options = {  types: ['(cities)'],  componentRestrictions: {country: 'in'}};

 new google.maps.places.Autocomplete(cityObj, options);
	
 
 /****************** Sort by rating *********************/
 
 
	
});

function customAlert(messageTitle, message){
	bootbox.alert({
	    title: messageTitle,
	    message: message,
	    className:'alertmodel'
	});
}

function setCategoryValue(categoryId){
	$("#artist_category_browse option").each(function () {
        if ($(this).val() == categoryId) {
            $(this).attr("selected", "selected");
            
         $('#artist_sub_category_browse').empty().append('<option selected disabled value="">Please select Sub Categories</option>');
   		 
   		 for(var i=0; i < subCategories.length; i++){
   			 if(subCategories[i][0] == categoryId){
   				 $("#artist_sub_category_browse").append(new Option(subCategories[i][2], subCategories[i][1]));
   			 }
   		 }
        
   		 return;
        }
	});
}	
	
function setSubCategoryValue(subCategoryId){
	
	$("#artist_sub_category_browse option").each(function () {
        if ($(this).val() == subCategoryId) {
            $(this).attr("selected", "selected");
            return;
        }
	});
}

function setCity(city){
	$('#location').val(city);
}
