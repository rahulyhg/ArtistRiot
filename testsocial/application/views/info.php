
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>TEST PROFILE</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url() ?>css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url() ?>css/jumbotron.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
	<?php 
	    //login confirmation
	//----	confirm_logged_in();
	?> 
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php"><B>ArtistRiot</B></a>
        </div>
        <form class="navbar-form navbar-left">
            <div class="form-group">
			<div class="rows">
              <input type="text" placeholder="Email" class="form-control" size="40">
            </div>
           </div>
          </form>
		<div class="navbar-collapse collapse">
         
          <form class="navbar-form navbar-right">
            <ul class="nav navbar-nav">
            <li class="active"><a href="home.php">Home</a></li>
           <li class="dropdown">
			
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php 
			//retrieve session variable
		//	echo $_SESSION['fName'];
                        	echo 'vatsal'; 
                        ?> 
				<b class="caret"></b>
			</a>
             
			 <ul class="dropdown-menu">
                <li><a href="#">My Profile</a></li>
                <li><a href="#">Edit profile</a></li>
                <li><a href="#">Edit profile Picture</a></li>
				<li><a href="#">Customize profile</a></li>
				<li><a href="#">Edit Work and Education</a></li>
               
              </ul>
            </li>
			<li class="dropdown">

			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<b class="caret"></b></a>
             
			 <ul class="dropdown-menu">
                <li><a href="#">Account Settings</a></li>
                <li><a href="#">Privacy Settings</a></li>
                <li><a href="#">Manage Social Accounts</a></li>
				<li><a href="#">Manage Credits</a></li>
				<li><a href="logout.php">Logout</a></li>
               
              </ul>
            </li>
          </ul>
		</form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
<div class="container">
		<div class="well">
		
			<div class="row">
				<div class="col-xs-12 col-md-2">
						<a data-target="#myModal" data-toggle="modal" href="" title=
						"Click here to Change Image.">
				<?php
				
			/*	$mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}'");
				$cur = $mydb->loadResultList();
				if ($mydb->affected_rows()== 0){*/
					echo '<img src="'. base_url(). 'images/uploads/p.jpg" class="img-thumbnail" width="200px" height="100px" />';	
				
			/*	} 
				foreach($cur as $object){
				   
						echo '<img src="./uploads/'. $object->filename.'" class="img-thumbnail" width="200px" height="100px" />';
					
					}	
				*/?> 
					</a>	
					
				<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal" type=
									"button">×</button>

									<h4 class="modal-title" id="myModalLabel">Choose Your best
									picture for your Profile.</h4>
								</div>

								<form action="save_photo.php" enctype="multipart/form-data" method=
								"post">
									<div class="modal-body">
										<div class="form-group">
											<div class="rows">
												<div class="col-md-12">
													<div class="rows">
														<div class="col-md-8">
															<input name="MAX_FILE_SIZE" type=
															"hidden" value="1000000"> <input id=
															"upload_file" name="upload_file" type=
															"file">
														</div>

														<div class="col-md-4"></div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="modal-footer">
										<button class="btn btn-default" data-dismiss="modal" type=
										"button">Close</button> <button class="btn btn-primary"
										name="savephoto" type="submit">Save Photo</button>
									</div>
								</form>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
				</div>

				<div class="col-xs-12 col-sm-6 col-md-8">
					<div class="page-header">
						<h3><?php //echo $_SESSION['fName']. ' '. $_SESSION['lName'];
                                                            echo 'Vatsal Gupta';
                                                ?></h3>
					</div>

					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#">Wall</a>
						</li>

						<li>
							<a href="info.php">Info</a>
						</li>

						<li>
							<a href="message.php">Messages</a>
						</li>
					</ul>

					<h1>Wall</h1>
				</div>
			</div>
		</div>
	</div>

	
     
  </body>
</html>
  
      <hr>
    
    </div> <!-- /container -->
	<footer>
        
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="<?php echo base_url() ?>js/tooltip.js"></script>
	<script src="<?php echo base_url() ?>js/jquery.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
  </body>
</html>
