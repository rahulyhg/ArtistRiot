<div class="panel-danger linespacer">
   
   <div>
   <h4>
   <?php 
   
   $firstName = $this->session->userdata('first_name');
   $lastName = $this->session->userdata('last_name');
   $subCategoryName = $this->session->userdata['sub_category_name'];
   
       if(!empty($firstName) && !empty($lastName)){
			echo $firstName.' '.$lastName;
		}
	?>
	</h4>
   </div>
   <div> 
       <small>
       <?php 
       if(!isEmpty($subCategoryName)){
			echo $subCategoryName;
		}
	?>
       </small>
   </div>
   
</div>