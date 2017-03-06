<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">
		
        <title><?php echo $title ?></title>
        <?php $this->view('profile/header-content'); ?>
    
    
    </head>

    <body>
        <!-- nav-content -->
        <?php $this->view('profile/profile-nav-content'); ?>
        <!-- ****************** -->       
        <div class="container" id="browseArtistContainer" >
            <div class="well">
				
				<hgroup class="mb20">
            		<h1 style="border-bottom: 2px solid #DFD7D5;"> Browse</h1>
        		</hgroup>
				
                <div class="row" style="margin-left:-15px;">
                   
                    <div class="col-xs-12 col-md-3 text-center" style="background: #f4f4f4;padding-top: 10px;">
                        <?php $this->view('browse/filter-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-9">
						<?php $this->view('browse/results-section'); ?>
                    </div>
                </div>
			</div>
        </div>
   
    <footer>
		<?php
			$this->view ( 'includes/home/footer_include' );
		?>
	</footer>
	
	<?php
	$this->view ( 'includes/home/tab_js' );
	$this->view ( 'includes/home/privacypolicy' );
	?>
	
	<script type="text/javascript">

		getSubCategories('<?php echo $sub_categories;?>');

	</script>
	
	<script type="text/javascript">
		
		<?php if(!empty($categoryId)){?>
			setCategoryValue('<?php echo $categoryId?>');
		<?php }?>

		<?php if(!empty($subCategoryId)){?>
			setSubCategoryValue('<?php echo $subCategoryId?>');
		<?php }?>

		<?php if(!empty($city)){?>
			setCity('<?php echo $city?>');
		<?php }?>

	</script>
		
</body>
</html>

 
