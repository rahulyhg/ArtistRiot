$(document).ready(function() {

    try {
        var searchData = $.jStorage.get('searchData');
        if (searchData == null || searchData == 'undefined' || searchData == 0) {
            console.log('search data found null');
            (function() {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.async = 'async';
                script.src = config.baseurljs + 'search/searchartist/getArtistsForSearch';
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(script, x);

                script.onload = script.onreadystatechange = function() {
                    if (!this.readyState || this.readyState === 'complete') {
                        $.jStorage.set('searchData', usersData);
                        $.jStorage.setTTL("searchData", 3600000);
                        console.log('search data loaded');
                        addAutoComplete();
                    }
                };
            })();
        }
        $("#searchdropdown li a").click(function() {
            // alert('yo');
            var selText = $(this).text();
            var value = $(this).attr('val');
            //   alert(value);
            $("#searchcategory").html(selText + ' <span class="caret"></span>');
            $("#searchcategory").val(selText);
            $("#searchcatinput").val(value);

        });

    }
    catch (e) {
        console.log('Error in search loader.');
    }

});

function addAutoComplete(){
	
	var searchData = $.jStorage.get('searchData');
	var ttl = $.jStorage.getTTL("searchData");
	
	if(searchData != null || searchData != 'undefined'){
  	  
		$("#searchbox").autocomplete({
    		delay: 0,
    		source:  $.map(searchData, function( item ) {
                return {
            	    label: item.name,
            	    value: item.name
                   
               };
           }),
    		
           minLength: 1
            
        });
    }
}
