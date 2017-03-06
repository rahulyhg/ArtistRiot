 <a href="<?php echo base_url().$role.'/'.$userName?>" >
<?php

       
       if(!empty($userProfileData)){  
       		echo '<img src="'.$userProfileData['user_image']. '" id="profile-pic" class="img-thumbnail padding-0" width="275px" height="100px" />';
       }
      
       else{
       		echo '<img src="' . base_url() . 'images/uploads/p.jpg" id="profile-pic" class="img-thumbnail padding-0" width="275px" height="100px" />';
       }
       ?>
</a>     
    
    
    
