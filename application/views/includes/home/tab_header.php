
<nav class="navbar navbar-default navbar-fixed-top navbar-shrink">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand page-scroll" href="#page-top">ArtistRiot</a>-->
            <a class="navbar-brand page-scroll" href="<?php echo base_url()?>" ><img style="margin-top:-12px" src="<?php echo base_url()?>img/logo_AR.png" ></img></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right ">
                
                <li id="about">
                    <a  href="<?php echo base_url() ?>page/howItWorks">How it works?</a>
                </li>
                <li id="services">
                    <a  href="<?php echo base_url() ?>page/whyUs">Why Us?</a>
                </li>
           <!--     <li id="trend">
                    <a  href="<?php echo base_url() ?>page/trends">Trends</a>
                </li> -->
                <li id="faq">
                    <a  href="<?php echo base_url() ?>page/faq">FAQs</a>
                </li>
                <li id="team">
                    <a  href="<?php echo base_url() ?>page/team">Team</a>
                </li>
                <li id="contact">
                    <a href="<?php echo base_url() ?>page/contact">Contact</a>
                </li>
                <?php 
                if($this->session->userdata('user_id') == null){
					
                ?>
				<li id="logintab" class="dropdown custom">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Login
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="logintabs" aria-labelledby="dropdownMenu">
                            <li><a data-toggle="modal" onclick="setArtistRole();" href="#login" style="color: black;">Login as Artist</a></li>
                            <li><a data-toggle="modal"  onclick="setVenueRole();" href="#login" style="color: black;">Login as Venue</a></li>
                    </ul>
                    
                </li>
                 <li id="signup">
                    <a data-toggle="modal" class="page-scroll" href="<?php echo base_url() ?>login/signup">Signup</a>
                </li>
                <?php } 
                else{
					?>
					<li id="logintab" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $this->session->userdata['first_name'].' '.$this->session->userdata['last_name'] ?>
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="logintabs" aria-labelledby="dropdownMenu">
                            <li><a data-toggle="modal" href="<?php echo base_url()?>login/loginform/logout" style="color: black;">Logout</a></li>
                            <li><a data-toggle="modal"  onclick="setVenueRole();" href="#login" style="color: black;">Help</a></li>
                    </ul>
                    
                </li>
                <?php }?>
            </ul>
        </div>
        <!-- Login Modal -->

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
    
    
</nav>



