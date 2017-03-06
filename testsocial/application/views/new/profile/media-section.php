<div class="list-group">
    <div class="list-group-item">
        <a href="<?php echo base_url() ?>artist/photos/true" title="Show my photos" style="cursor: pointer;text-decoration: none">
            <span class="badge pull-right">
                <?php
                /*  $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}'");
                  $cur = $mydb->executeQuery();
                  echo $row_count = $mydb->num_rows($cur);

                 */
                ?>            
                6 
            </span>

            My Photos &nbsp;
        </a>
        <a data-target="#modal-add-photo" data-toggle="modal" href="" title=
           "Add Photo">  <span class="glyphicon glyphicon-plus " />
        </a>

    </div>
    <div class="list-group-item">
        <a href="<?php echo base_url() ?>artist/videos/true" title="Show my videos" style="cursor: pointer;text-decoration: none" >
            <span class="badge pull-right">
                <?php
                /*  $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}'");
                  $cur = $mydb->executeQuery();
                  echo $row_count = $mydb->num_rows($cur);

                 */
                ?>            
                6 
            </span>

            My Videos &nbsp;
        </a>
        <a data-target="#modal-add-video" data-toggle="modal" href="" title=
           "Add Photo">  <span class="glyphicon glyphicon-plus " />
        </a>
    </div>
    
</div>

<!-- Modal Photo-->
<div class="modal fade" id="modal-add-photo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type=
                        "button">×</button>

                <h4 class="modal-title" id="myModalLabel">Add photos</h4>
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


<!-- Modal video -->
<div class="modal fade" id="modal-add-video" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type=
                        "button">×</button>

                <h4 class="modal-title" id="myModalLabel">Add Videos</h4>
            </div>

            <form action="save_video.php" enctype="multipart/form-data" method=
                  "post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="rows">
                            <div class="col-md-12">
                                <div class="rows">
                                    <fieldset>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="videourl">URL :</label>  
                                            <div class="col-md-8">
                                                <input id="textinput" name="videoUrl" placeholder="Copy And paste Youtube URL.." class="form-control input-md" required="" type="text">
                                                <span class="glyphicon glyphicon-question-sign pull-right" data-placement="left" title="Hint" data-toggle="popover" id="hint" data-content="The URL should be of a youtube video. Example-> http://www.youtube.com/watch?v=D9l68Jr_JDI"></span>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type=
                            "button">Close</button> <button class="btn btn-primary"
                            name="savephoto" type="submit">Save Link</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

