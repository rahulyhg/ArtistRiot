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
                    <input type="text" placeholder="Search For Artists..." class="form-control" size="40">
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
                            <li><a href="logout.php">Logout</a></li>

                        </ul>
                    </li>

                </ul>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</div>