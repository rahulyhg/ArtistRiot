<div class="panel-danger linespacer">
   <div>
   <h4>
    <a href="<?php echo base_url().$role.'/'.$userName?>" >
   <?php 
       if(!isEmpty($userProfileData)){
			echo $userProfileData['first_name'].' '.$userProfileData['last_name'];
		}
	?>
    </a>
    </h4>
    </div>
    <div>
       <small>
       <?php 
       if(!isEmpty($userProfileData)){
			echo $userProfileData['sub_category_name'];
		}
	?>
       </small>
   </div>
</div>