<div class="panel-danger">
   <h4>
   <?php 
   
   $firstName = $this->session->userdata('first_name');
   
       if(!empty($firstName)){
			echo $firstName;
		}
	?>
    
   </h4>
</div>