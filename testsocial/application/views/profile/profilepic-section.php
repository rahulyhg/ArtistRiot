
<?php
if ($is_my_profile)
{
    ?>

    <a data-target="#myModal" data-toggle="modal" href="" title=
       "Click here to Change Image." rel="tooltip">
           <?php
       }
       /* 	$mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}'");
         $cur = $mydb->loadResultList();
         if ($mydb->affected_rows()== 0){ */
       echo '<img src="' . base_url() . 'images/uploads/p.jpg" class="img-thumbnail" width="275px" height="100px" />';

       /* 	} 
         foreach($cur as $object){

         echo '<img src="./uploads/'. $object->filename.'" class="img-thumbnail" width="200px" height="100px" />';

         }
        */
       if ($is_my_profile)
       {
           echo '</a>';
       }
       ?>


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

                <form action="<?php echo base_url()?>actions/save_profile_pic.php" enctype="multipart/form-data" method=
                      "post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="rows">
                                <div class="col-md-12">
                                    <div class="rows">
                                        <div class="col-md-8">
                                            <input name="MAX_FILE_SIZE" type=
                                                   "hidden" value="1000000"> 
                                            <input id="profile_pic" name="profile_pic" type=
                                                   "file">
                                        </div>
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


