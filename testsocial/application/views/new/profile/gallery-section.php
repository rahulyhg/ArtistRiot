		

<div class="well" id="well">          
    <?php /* $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}'");
      $cur = $mydb->loadResultList();
      foreach ($cur as $object):
     */ ?>

    <!--     <a data-target="#myModall" data-toggle="modal" >
             <img src="./uploads/<?php //echo $object->filename;       ?> " class="img-thumbnail" width="200" height="200" />
         </a>
    -->

    <?php // endforeach;  ?>
    <?php
    if ($is_my_profile)
    {
        ?>
        
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url() ?>selfprofile">home</a></li>
            <li>/ photos</li>
        </ul>
    <?php } ?>

    <div class="row wrapper-parent">
        <div class="col-sm-4">
            <a href="<?php echo base_url() ?>images/uploads/02.jpg" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="People walking down stairs" >
                <img src="<?php echo base_url() ?>images/uploads/02.jpg" data-toggle="tooltip" title="People walking down stairs" class="img-responsive img-thumbnail">
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?php echo base_url() ?>images/uploads/Penguins.jpg" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="People walking down stairs" >
                <img src="<?php echo base_url() ?>images/uploads/Penguins.jpg" data-toggle="tooltip" title="People walking down stairs" class="img-responsive img-thumbnail">
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?php echo base_url() ?>images/uploads/Jellyfish.jpg" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="People walking down stairs" >
                <img src="<?php echo base_url() ?>images/uploads/Jellyfish.jpg" data-toggle="tooltip" title="People walking down stairs" class="img-responsive img-thumbnail">
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?php echo base_url() ?>images/uploads/02.jpg" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="People walking down stairs" >
                <img src="<?php echo base_url() ?>images/uploads/02.jpg" data-toggle="tooltip" title="People walking down stairs" class="img-responsive img-thumbnail">
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?php echo base_url() ?>images/uploads/Penguins.jpg" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="People walking down stairs" >
                <img src="<?php echo base_url() ?>images/uploads/Penguins.jpg" data-toggle="tooltip" title="People walking down stairs" class="img-responsive img-thumbnail">
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?php echo base_url() ?>images/uploads/Jellyfish.jpg" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="People walking down stairs" >
                <img src="<?php echo base_url() ?>images/uploads/Jellyfish.jpg" data-toggle="tooltip" title="People walking down stairs" class="img-responsive img-thumbnail">
            </a>
        </div>
    </div>

</div> 
