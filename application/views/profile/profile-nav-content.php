<div class="navbar navbar-inverse navbar-fixed-top" style="z-index:10;">
    <div class="container" style="margin-top: 0px;">
        <div class="navbar-header ">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-profile">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand page-scroll" href="#page-top">ArtistRiot</a>-->
                <a href="<?php echo base_url() ?>" ><img style="margin-top:4px" src="<?php echo base_url() ?>img/logo_AR.png" ></img></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-profile">

            <form role="search" id="searchartistform" class="navbar-form navbar-left" style="margin-top: 7px;" method="POST">
                <div class="form-group">
                    <input id="searchbox" name="searchbox" size="50" type="text" placeholder="Search For Artists..." class="form-control">

                    <span id='button-holder' >
                        <i class="glyphicon glyphicon-search search-icon"></i>
                    </span>
                    <input type="submit" style="display:none"/>
                </div>

            </form>

            <ul class="nav navbar-nav navbar-right">
                <?php
                if (!empty($this->session->userdata('user_id')))
                {
                    ?>  
                    <li ><a class="profile-links" href="<?php echo base_url() ?>profile/artist">Home</a></li>
                    <li ><a class="profile-links" href="<?php echo base_url() ?>profile/artist/videos">My Videos</a></li>
                    <li><a class="profile-links"  href="<?php echo base_url() ?>profile/artist/photos">My Photos</a></li>
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle profile-links" data-toggle="dropdown">
                            <?php
                           		echo $this->session->userdata['first_name'];
                           ?>
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() ?>profile/artist/edit" ><span class="glyphicon glyphicon-pencil"></span>  Edit profile</a></li>
                            <li><a href="<?php echo base_url()?>login/loginform/logout"><span class="glyphicon glyphicon-off"></span>  Logout</a></li>
						</ul>
                    </li>
                    <?php
                }
                else
                {
                    ?>
                    <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Login
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="logintabs">
                            <li><a data-toggle="modal" onclick="setArtistRole();" href="#login" style="color: black;">Login as Artist</a></li>
                            <li><a data-toggle="modal"  onclick="setVenueRole();" href="#login" style="color: black;">Login as Venue</a></li>
                    </ul>
                	</li>
                	 <li>
                  	  <a  href="<?php echo base_url()?>login/signup">Signup</a>
                	</li>
                    
                    <?php } ?>

                </ul>
            
        </div><!--/.navbar-collapse -->
    </div>
</div>
<!-- Login Modal -->
		<?php
			$this->view('login/login.php');
		?>