

<div class="" id="well" style="padding-left: 30px;">          

	<div class="row">
	<div class="col-md-4 review-instructions">
		<p><span class="boldtext bmargin10">What makes a good review</span></p>
		<strong>Have you watched this Artist?</strong>
		<p><span class="bmargin10">Its always better to review an artist you have personally watched.</span></p>
		<strong>Educate your readers</strong>
		<p><span class="bmargin10">Provide a relevant, unbiased overview of the artist. 
		Readers are interested in the experience of the artist.</span></p>
		<strong>Be yourself, be informative</strong>
		<p><span class="bmargin10">Let your personality shine through, but it's 
		equally important to provide facts to back up your opinion.</span></p>
		<strong>Get your facts right!</strong>
		<p><span class="bmargin10">Nothing is worse than inaccurate information. If you're not really sure, research always helps.</span></p>
		<strong>Stay concise</strong>
		<p><span class="bmargin10">Be creative but also remember to stay on topic. A catchy title will always get attention!</span></p>
		<strong>Easy to read</strong>
		<p><span class="bmargin10">A quick edit and spell check will work wonders for your credibility. 
		Also, break reviews into small paragraphs.</span></p>
			
	</div>
	
	<div class="col-md-7" id="review-form-display">
	
		<div class="form-group col-md-12">
			<p> All fields are mandatory.</p>	
				
		</div>
		 <div class='form_error_message'>
                                <?php
                                echo validation_errors();
                                ?>
         </div>
                            
		<?php
					$attributes = array (
							'id' => 'reviewform',
							'data-toggle' => 'validator' 
					);
					echo form_open ( 'profile/artistreview/addartistreview', $attributes );
		?>
		<div class="form-group">
		
						<label for="reviewername" class="col-md-3 control-label">Your Name: </label>
						<div class="col-md-9 linespacer">
							<input type="text" class="form-control" id="reviewername"
								name="reviewername" placeholder="First and last name">
							<p class="help-block"></p>
						</div>
		</div>
		
		<div class="form-group">
						<label for="reviewtitle" class="col-md-3 control-label">Review Title: </label>
						<div class="col-md-9 linespacer">
							<input type="text" class="form-control" id="reviewtitle"
								name="reviewtitle" placeholder="Review Title">
							<p class="help-block"></p>
						</div>
		</div>
		
		<div class="form-group">
						<label for="review" class="col-md-3 control-label">Your Review: </label>
						<div class="col-md-9 linespacer">
							<div class="review_text-message">
							<div><strong>Please do not include: HTML, references to other artists, personal information, 
							inflammatory or copyrighted comments, or any copied content.</strong></div>
							</div>
							<textarea class="form-control" id="review"
								name="review" rows="10"></textarea>
							<span id="text_counter"></span>
						</div>
		</div>
		
		<div class="form-group ">
						<label for="rating_score" class="col-md-3 control-label">Your Rating: </label>
						<div class="col-md-9 linespacer">
							<div id="star">
								
							</div>
                         	<input type="hidden" id="rating_score" name="rating_score">
                         	<input type="hidden" id="reviewer_email" name="reviewer_email">
                         	
						</div>
		</div>
		<input type="hidden" id="artist_id" name="artist_id" value="<?php echo $artist_id?>">
		<div class="form-group">
						<div class="col-md-offset-3 col-md-4">
							<button type="submit" id="submitreviewbutton" style="display: block; width: 100%;"
								class="btn btn-default btn-success">Submit</button>
						</div>
		</div>
		<?php echo form_close();?>
		
	</div>
	
	<div class="col-md-7 text-center review-thanks-message" id="review-form-response">
		Thank you for the review.
	</div>
	
	</div>
	
    
    

</div>

