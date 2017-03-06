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

    </head>
    
    <body id="page-top" class="index" lang="<?php echo $language; ?>">


        <!-------------- Navigation Bar -------->
        <?php
        $this->view('includes/home/tab_header');
        ?>

        <?php
        $this->view('includes/home/' . $tab . '_include');
        ?>


        <footer>
            <?php $this->view('includes/home/footer_include'); ?>
        </footer>

        <!-- Load js files in the end----->

        <?php $this->view('includes/home/tab_js'); ?>
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
