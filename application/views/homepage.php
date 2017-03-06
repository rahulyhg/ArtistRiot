<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8"/>
        <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
        <meta name="description" content="<?php echo $meta_description; ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <?php $this->view('includes/home/head_include'); ?>
        
        <script>
            var config ={
            baseurljs : "<?php echo base_url()?>"
        };

        </script>
        
    </head>

    <body id="page-top" class="index" lang="<?php echo $language; ?>">
		
		<div class="blocking-div" style="display: none;"></div>
		
        <!-------------- Navigation Bar -------->
        <?php
        	$this->view('includes/home/nav_include');
        ?>


        <!-- Header -->
        <header>
            <?php
            $this->view('includes/home/search_include');
            ?> 
        </header>
        <!-------------- Banners -------->
        <!--NOt in phase 1-->
        
        
        <!-- About US -->
        <?php
        $this->view('includes/home/about_include');
        ?>


        <!-- Services -->
        <?php
        $this->view('includes/home/services_include');
        ?>




        
        <!-- Trending Artists/Venues -->
        <?php
        //$this->view('includes/home/trend_include');
        ?>
           
        <!-- FAQ Page -->
        <?php
        $this->view('includes/home/faq_include');
        ?>
        
        <!-- Team -->
        <?php
        $this->view('includes/home/team_include');
        ?>

        <!-- Contact US -->
        <?php
        $this->view('includes/home/contact_include');
        ?>

        <footer>
            <?php $this->view('includes/home/footer_include'); ?>
        </footer>

        <!-- Load js files in the end----->

        <?php $this->view('includes/home/js_include'); ?>

		<!-- Login Modal -->
		<?php
			$this->view('login/login.php');
		?>

        <!-- Privacy policy -->
        <?php
        $this->view('includes/home/privacypolicy');
        ?>

    </body>
</html>
