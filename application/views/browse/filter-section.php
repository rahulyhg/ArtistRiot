<div class="row" style="margin-left: -15px;">
	
	<div class="form-group linespacer">
		<label class="col-md-12 control-label text-center" for="artist_category">Artist Category </label>
			<div class="col-md-12 linespacer ">

			<select id="artist_category_browse" name="artist_category" class="form-control">
				<option selected value="-1">Please select a category</option>
					<?php
					foreach ( $categories as $categoryarray ) {
						echo '<option value="' . $categoryarray [0] . '">' . $categoryarray [1] . '</option>';
					}
					?>
					</select>
			</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-12 control-label text-center" for="artist_sub_category">Genre </label>
			<div class="col-md-12 linespacer ">

			<select id ="artist_sub_category_browse" name="artist_sub_category" class="form-control">
				
			</select>
			</div>
	</div>
	
	<div class="form-group text-center">
		<label class="col-md-12 control-label text-center" for="location">Location </label>
			<div class="col-md-12 linespacer ">

			<input type="text" id="location" name="location" class="form-control"/>
			
			</div>
	</div>
	
	<div class="form-group ">
		<label class="col-md-12 control-label text-center" for="location">Filter By Price </label>
			<div class="col-md-12" style="margin-bottom:10px;">
				<div id="amount"><i class="fa fa-rupee"></i> 5000 - <i class="fa fa-rupee"></i> 100000</div>
			</div>
			
			<div id="slider-range" class="col-md-12 linespacer" style="max-width:80%;margin-left:10%;">
			</div>
	</div>
	
	<div class="form-group">
		
			<div class="col-md-12 linespacer ">

				<button type="submit" id="browseartist" style="display: block; width: 100%;"
								class="btn btn-default btn-success">Search Artists</button>
				
		</div>
	</div>
	
</div>



	
