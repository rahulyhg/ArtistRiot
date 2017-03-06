<?php 

$description = (!empty($userProfileData['description'])) ? ($userProfileData['description']) : ''; 

?>


<div class="form-group linespacer">
    	<div class="aboutme-artist">About Me</div>
		
        <div class="margin-top-10 word-wrap bubble" id="description">
                
                	<?php echo $description ?>	

                    <div class="clearfix"></div>
                
        </div>

        <div class="clearfix"></div>
        
    
</div>