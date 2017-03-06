
<div class="well" style="  min-height: 288px;background: #f4f4f4;">          

	<div class="row linespacer" style="margin-left:0px;border-bottom: 2px solid #dfe0e1;padding-bottom: 5px;">
	
	<div class="col-md-4 col-xs-12" style="float:left;">
		<span style="float:left;"><h4>Results</h4></span>
	</div>
	<div class="col-md-3 col-xs-12" style="float:right;">
		<select id="sort_rating" name="sort_rating" class="form-control">
				<option selected disabled value="-1">Sort by Rating</option>
				<option value="desc">High to low</option>
				<option value="asc">Low to high</option>
		</select>		
	</div>
	
	<div class="col-md-3 col-xs-12" style="float:right;">
		<select id="sort_price" name="sort_price" class="form-control">
				<option selected disabled value="-1">Sort by Price</option>
				<option value="desc">High to low</option>
				<option value="asc">Low to high</option>
		</select>		
	</div>
	
    </div>
    
    <div class="row wrapper-parent " id="browseResultsSection" style="margin-left:0px;">
     	
     	<?php if(!empty($searchData)){ 
     		foreach ( $searchData as $browseResultData ) { ?>
     		
     			<div class="item col-xs-12 col-sm-6 col-md-4 linespacer browse-tile">
                <div class="text-center" style="box-shadow: 0 0 5px 1px #c7c7c7;padding-top: 19px;  background-color: #fff;
                border: 1px solid #e3e3e3;">
               	<?php if(!empty($browseResultData['user_image_path'])){ ?>    
					<a href="<?php echo base_url().$browseResultData['role'].'/'.$browseResultData['userName']?>">
                        <img class="img-thumbnail padding-0" src="<?php echo $browseResultData['user_image_path']?>" 
                        width="160px" height="120px">
                    </a>
				<?php } else{?>
					<a href="<?php echo base_url().$browseResultData['role'].'/'.$browseResultData['userName']?>">
                        <img class="img-thumbnail padding-0" src="http://artistriot.com/artistriot/images/uploads/p.jpg" 
                        width="160px" height="120px">
                    </a>
				<?php }?>

					<h4 class="text-center"><a href="<?php echo base_url().$browseResultData['role'].'/'.$browseResultData['userName']?>">
						<?php echo $browseResultData['first_name'].' '.$browseResultData['last_name']?></a></h4>
					<p><b><?php echo $browseResultData['sub_category_name']?></b></p>
					<div><b>City:</b> <?php echo $browseResultData['city']?></div>
        			<div><b>Rating:</b><span class="rating"> <?php echo $browseResultData['rating']?> </span></div>
                    <div>
                    
					<button type="button" id="" style="display: block; width: 100%;background-color: rgb(136, 183, 224);
                    border-color: rgb(136, 183, 224);opacity: 0.6;"
								class="btn btn-default btn-success">Contact</button>
                    </div>
                </div>
       </div>
     			
     	<?php }
     	}?>	
     
     	
    <div id="browseresultsloader" class="divloader" style="display: none;"></div>    
    </div>
    
<div class="loader_image row-centered"><img src="<?php echo base_url() ?>images/load.gif"></div>

    
<script id="searchResultTemplate1" type="text/html">

<article class="browse-result">
    <div id= "${user_id}" class="col-xs-6 col-sm-6 col-md-3">
   
	{{if (user_image_path != '')}}
     <a href="<?php echo base_url()?>${role}/${userName}" title="${userName}" class="thumbnail">
     	<img src="${user_image_path}" class="img-thumbnail padding-0" 
                  alt="${userName}" width="140px" height="120px"/>
     </a>
	{{else}}
     
     <a href="<?php echo base_url()?>${role}/${userName}" title="${userName}" class="thumbnail"><img src="http://artistriot.com/artistriot/images/uploads/p.jpg" alt="${userName}" width="275"/></a>  
	
	{{/if}}
   </div>
                    
     <div class="col-xs-6 col-sm-6 col-md-7 excerpet">
     	 <h3><a href="<?php echo base_url()?>${role}/${userName}" title="${userName}">${first_name}  ${last_name}</a></h3>
         <p><b>${sub_category_name}</b></p>
         <div><b>City:</b> ${city}</div>
         <div><b>Rating:</b> ${rating}</div>						
     </div>
                    
     <span class="clearfix borda"></span>
 </article>	

</script>

<script id="searchResultTemplate" type="text/html">


    <div class="item col-xs-12 col-sm-6 col-md-4 linespacer browse-tile">
                <div class="text-center" style="box-shadow: 0 0 5px 1px #c7c7c7;padding-top: 19px;  background-color: #fff;
                border: 1px solid #e3e3e3;">
                {{if (user_image_path != '')}}    
					<a href="<?php echo base_url()?>${role}/${userName}" >
                        <img class="img-thumbnail padding-0" src="${user_image_path}" 
                        width="160px" height="120px">
                    </a>
				{{else}}
					<a href="<?php echo base_url()?>${role}/${userName}">
                        <img class="img-thumbnail padding-0" src="http://artistriot.com/artistriot/images/uploads/p.jpg" 
                        width="160px" height="120px">
                    </a>
				{{/if}}

					<h4 class="text-center"><a href="<?php echo base_url()?>${role}/${userName}">${first_name}  ${last_name}</a></h4>
					<p><b>${sub_category_name}</b></p>
					<div><b>City:</b> ${city}</div>
        			<div><b>Rating:</b><span class="rating"> ${rating} </span></div>
                    <div>
                    
					<button type="button" id="" style="display: block; width: 100%;background-color: rgb(136, 183, 224);
                    border-color: rgb(136, 183, 224);opacity: 0.6;"
								class="btn btn-default btn-success">Contact</button>
                    </div>
                </div>
       </div>


</script>	

<script id="blankResultTemplate" type="text/html">

<article class="browse-result">
    <div class="text-center"> No Results Found. </div>
 </article>	

</script>


</div> 
