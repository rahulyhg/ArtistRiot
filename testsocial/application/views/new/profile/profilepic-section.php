
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
       //echo '<img src="' . base_url() . 'images/uploads/649.jpg" class="img-thumbnail" width="275px" height="100px" />';


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

                <!-- <form action = "<?php echo base_url() ?>artistv2/save_profile_pic" enctype="multipart/form-data" method="post">
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
                </form>-->
                <div class="row">
                    <div class="col-lg-6" id="crop-section" style="display:none">
                        <img src="" id="thumbnail" alt="Create Thumbnail" />
                        <div id="thumb_preview_holder">					
                            <img src=""  alt="Thumbnail Preview" id="thumb_preview" />
                        </div>
                        <div>
                            <input type="hidden" name="filename" value="" id="filename" />
                            <input type="hidden" name="x1" value="" id="x1" />
                            <input type="hidden" name="y1" value="" id="y1" />
                            <input type="hidden" name="x2" value="" id="x2" />
                            <input type="hidden" name="y2" value="" id="y2" />
                            <input type="hidden" name="w" value="" id="w" />
                            <input type="hidden" name="h" value="" id="h" /><br>

                            <input type="submit" class="btn btn-primary button" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
                        </div>
                    </div>

                    <div class="col-lg-6" id="uploader-section">
                        <div class="product_image">	
                            <img src="" class="thumbnails" />
                        </div>
                        <div id="file-uploader">
                            <button id="upload" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;<span class="upload">Change profile picture</span></button>
                            <noscript>			
                            <p>Please enable JavaScript to use file uploader.</p>
                            <!-- or put I could put an upload form here -->
                            </noscript> 
                        </div>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
