<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
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
            <ul class="nav navbar-nav navbar-right">

                <li>
                    <a class="page-scroll" href="#about">How it works?</a>
                </li>
                <li>
                    <a class="page-scroll" href="#services">Why Us?</a>
                </li>
              <!--  <li>
                    <a class="page-scroll" href="#portfolio">Trends</a>
                </li> -->
                <li>
                    <a class="page-scroll" href="#faq">FAQs</a>
                </li>
                <li>
                    <a class="page-scroll" href="#team">Team</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Contact</a>
                </li>
                <li>
                    <a class="page-scroll" href="<?php base_url()?>browse">Browse</a>
                </li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" id="logintabs">Login
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu" >
                        <li><a data-toggle="modal" class="page-scroll" onclick="setArtistRole();" href="#login" style="color: black;">Login as Artist</a></li>
                        <li><a data-toggle="modal" class="page-scroll"  onclick="setVenueRole();" href="#login" style="color: black;">Login as Venue</a></li>
                    </ul>
                </li>
                 <li>
                    <a data-toggle="modal" class="page-scroll" href="login/signup">Signup</a>
                </li>
            </ul>
        </div>
        
 
        <!-- /.navbar-collapse -->
    </div>
    
    
    <!-- /.container-fluid -->
</nav>


