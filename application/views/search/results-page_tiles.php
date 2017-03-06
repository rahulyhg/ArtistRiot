
<div class="panel panel-success" id="performance-panel">
    <div class="panel-heading">
        <div class="panel-title text-center">Search Results for "<?php echo $searchQuery?>"</div>
        <!--     <a data-target="#addPerformanceModal" data-toggle="modal" href="" title=
                "Click here to ad your reviews."><i class="glyphicon glyphicon-plus-sign pull-right">Add</i></a></small></h3></div>
        -->
    </div>
    <div class="panel-body">

        <div id="posts" class="row">
            <?php if($searchResultsData != ''){
            
            	foreach ($searchResultsData as $searchData){
					?>
			<div id="<?php echo $searchData['user_id'] ?>" class="item col-xs-12 col-sm-3 col-md-3">
                <div class="well text-center">
                    <?php 
                    if($searchData['user_image_path'] != ''){
                    ?>
                    <a href="<?php echo base_url().$searchData['role'].'/'.$searchData['userName']?>"  >
                        <img class="thumbnail img-responsive padding-0" src="<?php echo $searchData['user_image_path'] ?>" height="200" width="200">
                    </a>
                    <?php }
                    else{

                    ?><a href="<?php echo base_url().$searchData['role'].'/'.$searchData['userName']?>">
                    	<img class="thumbnail img-responsive padding-0" src="http://artistriot.com/artistriot/images/uploads/p.jpg" height="200" width="200">
                      </a>
                    <?php }
                    ?>
					<div style="color:red;">
						<h5><a href="<?php echo base_url().$searchData['role'].'/'.$searchData['userName']?>"  >
							<?php echo $searchData['first_name'].' '.$searchData['last_name'] ?></a></h5> 
					</div>
					<div>
						<?php echo $searchData['sub_category_name'] ?>
					</div>
					<div class="horizontal-line">
					</div>
					<div class="artist-description">
						<div>Lives in <?php echo $searchData['city'] ?></div>
						<div>Skills: Guitar.</div>
						<div>Available for: Shows</div>
						<div>Rating</div>
					</div>
					
                </div>
            </div>
            <?php 
            }
            }
            else{

            ?>
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="align:center;"> No results found. </div>
            
            <?php }?>
            
        </div>
    </div>
</div>

