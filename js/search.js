$(document).ready(function() {
	
	/******* Search box click ********/
	
	$('.suggested-categories').click(function(){
		
		$('#search-input-dropdown').css('display','none');
		$('.blocking-div').css('display','none');
		
		var text = $(this).text();
		$('#searchbox').val(text);
		
		window.location.href = config.baseurljs + 'browse/category/' + text;
	 });

	$("#searchbox" ).keypress(function() {
		$('#search-input-dropdown').css('display','none');
		$('.blocking-div').css('display','none');
	});
	
	$(document).click(function(e) {
		
		var subject = $("#searchbox"); 
		
		if( (e.target.id == subject.attr('id')) || ($(e.target).parents("#search-input-dropdown").size()))
        {
			$('#search-input-dropdown').css('display','block');
			$('.blocking-div').css('display','block');
        }
		else{
			$('#search-input-dropdown').css('display','none');
			$('.blocking-div').css('display','none');
		}
	});
	
	
	
	

	$('#searchartistbutton').click(function(e) {

        //  e.preventDeafult();
        search();
    });

    $('#searchbox').keypress(function(e) {
        if (e.keyCode == 13) {

         //   e.preventDeafult();
            search();
        }
    });

    $('.search-icon').click(function() {

        var searchText = getValue('searchbox').trim();

        if (validateSearchForm()) {
            $('#searchartistform').attr('action', config.baseurljs + 'search/artists/' + searchText);
            $('#searchartistform').submit();
        }
        else {
            return false;
        }

    });
    
    function getValue(id) {

        var value = '';

        if (document.getElementById(id) != null)
            value = document.getElementById(id).value;

        return value;
    }

    function validateSearchForm() {

        var searchText = getValue('searchbox').trim();

        if (searchText == '') {
            return false;
        }
        else {
            return true;
        }

    }

    function search() {
        var searchText = getValue('searchbox').trim();
        //var category = $("#searchcatinput").val();
        var category = $("#searchcategory").val();
        if (category != null) {
            category = category.toLowerCase();
        }
        if (validateSearchForm()) {
            $('#searchartistform').attr('action', config.baseurljs + 'search/artists/' + category + '/' + searchText);
            $('#searchartistform').submit();
        }
        else {
            return false;
        }

    }
    //Getting search data

    var searchData = $.jStorage.get('searchData');
    var ttl = $.jStorage.getTTL("searchData");

    if (searchData != null || searchData != 'undefined') {
    	
        $("#searchbox").autocomplete({
            delay: 0,
            source: $.map(searchData, function(item) {
            	
                return {
                    label: item.name,
                    value: item.name

                };
            }),
            minLength: 1

        });
    }

    


    /****Search Results Star Rating*****/
    // for populating star raing insearch results.. The value should be there in attribute- 'datarating'
    // for example--<span class='pull-right stars_small' data-rating='3'></span>
    /*  $('.stars_small').raty({
     readOnly: true,
     half: true,
     path: config.baseurljs + 'images',
     score: function() {
     return this.getAttribute('data-rating');
     // return 3;
     },
     space: false
     
     });*/
    
});


