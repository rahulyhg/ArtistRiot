<div class="navbar navbar-inverse navbar-fixed-top" style="z-index:1;">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                
            </button>
            <!--<a class="navbar-brand page-scroll" href="#page-top">ArtistRiot</a>-->
            <a class="navbar-brand page-scroll" href="<?php echo base_url()?>" ><img style="margin-top:-12px" src="<?php echo base_url()?>img/logo_AR.png" ></img></a>
        </div>
        <form class="navbar-form navbar-left" style="margin-bottom: 0px;">
            <div class="form-group">
                <div class="rows">
                    <input id="profile-search-bar" type="text" placeholder="Search For Artists..." class="form-control" size="40">
                </div>
            </div>
        </form>
       
       
        <div class="navbar-collapse collapse">

            <form class="navbar-form navbar-right" style="margin-bottom: 0px;">
                <ul class="nav navbar-nav">
               <?php  if($this->session->userdata('user_id') != ''){  ?>  
                    <li class="active"><a class="profile-links" href="<?php echo base_url()?>profile/artist">Home</a></li>
                    <li class="active"><a class="profile-links" href="#">My Events</a></li>
                    <li class="active"><a class="profile-links" href="<?php echo base_url()?>profile/artist/videos">My Videos</a></li>
                    <li class="active"><a class="profile-links" href="<?php echo base_url()?>profile/artist/photos">My Pictures</a></li>
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle profile-links" data-toggle="dropdown">
                            <?php 
       							if($this->session->userdata('user_id') != null){
									echo $this->session->userdata['first_name'];
								}
							?>
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="#">My Profile</a></li>
                            <li><a href="#">Edit profile</a></li>
                            <li><a href="#">Edit profile Picture</a></li>
                            <li><a href="<?php echo base_url()?>login/loginform/logout">Logout</a></li>

                        </ul>
                    </li>
                    <?php } else {?>
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
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</div>
<!-- Login Modal -->
		<?php
			$this->view(base_url() . 'login/login.php');
		?>