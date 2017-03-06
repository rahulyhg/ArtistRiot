<div class="column ">
	
	<?php	
	   if(!empty($venueProfileData)){ ?>
			<div class='row'>
			<div class="col-md-7 col-xs-7 text-left venue-name linespacer venue-details">
				
				<?php	
	   				if(!empty($venueProfileData['first_name'])){  
	   					echo $venueProfileData['first_name'];
	   				}
	   			 ?>
			</div>
			<?php	
	   		if(!empty($venueProfileData['fb_link'])){   ?>
			<div class='col-md-5 col-xs-12'>
					<div class="form-group linespacer">
						<div class="">
							<div class="fb-like" data-href="<?php echo $venueProfileData['fb_link'];?>"
	   						data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
	   						
						</div>
					</div>
					
					
				</div>
				
			<?php }?>
			</div>
			
			<div class='row'>
				<div class='col-md-7 col-xs-9'>
					<div class="form-group linespacer">
						<div class="venue-section-heading ">About Venue</div>
						<div class="venue-details">
							<?php	
	   							if(!empty($venueProfileData['venue_description'])){  
	   								echo $venueProfileData['venue_description'];
	   							}
	   			 			?>
						</div>
					</div>
					
					<div class="form-group linespacer">
						<div class="venue-section-heading ">Location</div>
						<div class="venue-details">
							<?php	
	   							if(!empty($venueProfileData['venue_city'])){  
	   								echo $venueProfileData['venue_city'];
	   							}
	   			 			?>
						</div>
					</div>
					
					<div class="form-group linespacer">
						<div class="venue-section-heading ">Events</div>
						<div class="venue-details">
							<?php	
	   							if(!empty($venueProfileData['event_names'])){  
	   								echo $venueProfileData['event_names'];
	   							}
	   			 			?>
						</div>
					</div>
					
				</div>
				
			</div>
			
	<?php } ?>

</div>