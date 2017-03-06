		

<div class="well" id="well">          
    <?php /* $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}'");
      $cur = $mydb->loadResultList();
      foreach ($cur as $object):
     */ ?>

    <!--     <a data-target="#myModall" data-toggle="modal" >
             <img src="./uploads/<?php //echo $object->filename;        ?> " class="img-thumbnail" width="200" height="200" />
         </a>
    -->

    <?php // endforeach;  ?>
 <?php
           
            if ($is_my_profile=="true")
            {
                
                ?>
            
    <ul class="breadcrumbs">
            <li><a href="<?php echo base_url()?>artist/index/true">home</a></li>
            <li>/ videos</li>
        </ul>
            <?php } ?>
    <div class="row wrapper-parent">

        

        <div id="video" class="col-sm-4">
            <a href="http://www.youtube.com/watch?v=k6mFF3VmVAs" data-toggle="lightbox" data-title="People walking"><img class="img-thumbnail"  data-toggle="tooltip" title="video" src="http://img.youtube.com/vi/XNMMrbHMiNM/1.jpg" width="200px" height="200px" />
                <span class="play"></span> 
            </a>
        </div>
        <div id="video" class="col-sm-4">
            <a href="http://www.youtube.com/watch?v=k6mFF3VmVAs" data-toggle="lightbox" data-title="People walking"><img class="img-thumbnail"  data-toggle="tooltip" title="video" src="http://img.youtube.com/vi/XNMMrbHMiNM/1.jpg" width="200px" height="200px" />
                <span class="play"></span> 
            </a>
        </div>
        <div id="video" class="col-sm-4">
            <a href="http://www.youtube.com/watch?v=k6mFF3VmVAs" data-toggle="lightbox" data-title="People walking"><img class="img-thumbnail"  data-toggle="tooltip" title="video" src="http://img.youtube.com/vi/XNMMrbHMiNM/1.jpg" width="200px" height="200px" />
                <span class="play"></span> 
            </a>
        </div>
        <div id="video" class="col-sm-4">
            <a href="http://www.youtube.com/watch?v=k6mFF3VmVAs" data-toggle="lightbox" data-title="People walking"><img class="img-thumbnail"  data-toggle="tooltip" title="video" src="http://img.youtube.com/vi/XNMMrbHMiNM/1.jpg" width="200px" height="200px" />
                <span class="play"></span> 
            </a>
        </div>
        <div id="video" class="col-sm-4">
            <a href="http://www.youtube.com/watch?v=k6mFF3VmVAs" data-toggle="lightbox" data-title="People walking"><img class="img-thumbnail"  data-toggle="tooltip" title="video" src="http://img.youtube.com/vi/XNMMrbHMiNM/1.jpg" width="200px" height="200px" />
                <span class="play"></span> 
            </a>
        </div>
        <div id="video" class="col-sm-4">
            <a href="http://www.youtube.com/watch?v=k6mFF3VmVAs" data-toggle="lightbox" data-title="People walking"><img class="img-thumbnail"  data-toggle="tooltip" title="video" src="http://img.youtube.com/vi/XNMMrbHMiNM/1.jpg" width="200px" height="200px" />
                <span class="play"></span> 
            </a>
        </div>
    </div>
</div>   