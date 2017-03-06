
<div class="container">
    <div class="intro-text row ">
        <div class="intro-lead-in">Search for artists!</div>
        <div class="row">
            <div class="form-wrapper cf col-lg-8 col-md-8 col-sm-12  col-xs-12 col-lg-push-2 col-md-push-1 "
            style="background:none;box-shadow: none;">
                <?php
                $attributes = array(
                    'id' => 'searchartistform',
                    'data-toggle' => 'validator'
                );
                echo form_open_multipart('', $attributes);
                ?>
 
                <input type="hidden" id="searchcatinput" name="searchcatinput" val="-1"/>
                
                <div class="col-md-offset-2 col-lg-offset-2 col-sm-offset-2 col-sm-7 col-md-7 col-xs-7 pull-left ">
                <div id="searchtext">
                <span class="glyphicon glyphicon-search search-bar-icon " 
                style="position: absolute;right: 0;padding: 12px 21px;color: rgb(163, 156, 156);"></span>
                <input  class = "txt-auto ui-widget" id="searchbox" style="width:100%;"
                	name="searchbox" type="text" placeholder="Search for artists" required >
                </div>
                <div id="search-input-dropdown" style="display:none;">
                	<ul id="categorydropdown">
  					<li>Suggested Categories</li>
  					<?php
					foreach ( $categories as $categoryarray ) {
						echo '<li class="suggested-categories">' . $categoryarray [1] . '</li>';
					}
					?>
  					
   				</ul>
   				</div>
   				</div>	
                <button class = "col-lg-2 col-sm-2 col-md-2 col-xs-2 pull-left" id="searchartistbutton" name="searchartistbutton" type="submit" href="#"></button>
				
				
                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>


