<div class="panel panel-success">
    <?php
    //$member_id = $this->session->userdata('member_id');
    //$profile_id = "";
    //if($member_id == $profile_id )
    //  $is_my_profile = "yes";
    ?>

    <?php
    //  $mydb->setQuery("Select * from basic_info where member_id=" . $_SESSION['member_id']);
    // $info = $mydb->loadSingleResult();
    ?>

    <div class="panel-heading">
        <h3 class="panel-title">Basic Info
            <?php
            if ($is_my_profile)
            {
                ?>
                <a data-target="#modal-edit-abtme" data-toggle="modal" href="" title=
                   "Edit your personal info"><span class="pull-right glyphicon glyphicon-edit">Edit</span></a>
               <?php } ?>
        </h3>

    </div>
    <!-- form start for edit option -->

    <!-- Modal -->
    <div class="modal fade" id="modal-edit-abtme" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type=
                            "button">×</button>

                    <h4 class="modal-title" id="myModalLabel">Edit Your Personal Info:</h4>
                </div>
                <form action="save_personal_info.php" enctype="multipart/form-data" method=
                      "post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="rows">
                                <div class="col-md-12">
                                    <div class="rows">

                                        <fieldset>

                                            <!-- Text input-->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="textinput">Name</label>  
                                                <div class="col-md-6">
                                                    <input id="textinput" name="textinput" placeholder="My name is....." class="form-control input-md" required="" type="text">

                                                </div>
                                            </div>

                                            <!-- Text input-->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="Talent">Talent</label>  
                                                <div class="col-md-6">
                                                    <input id="Talent" name="Talent" placeholder="Your main skill" class="form-control input-md" required="" type="text">

                                                </div>
                                            </div>

                                            <!-- Text input-->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="skillls">Skills</label>  
                                                <div class="col-md-6">
                                                    <input id="skillls" name="skillls" placeholder="Your other skills" class="form-control input-md" required="" type="text">

                                                </div>
                                            </div>

                                            <!-- Text input-->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="contact">Contact Number</label>  
                                                <div class="col-md-6">
                                                    <input id="contact" name="contact" placeholder="We can reach you at?" class="form-control input-md" type="text">

                                                </div>
                                            </div>

                                            <!-- Textarea -->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="address">Your Address</label>
                                                <div class="col-md-6">                     
                                                    <textarea class="form-control" id="address" name="address">You can meet me at:</textarea>
                                                </div>
                                            </div>

                                            <!-- Multiple Radios -->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="availability">Availability</label>
                                                <div class="col-md-6">
                                                    <div class="radio">
                                                        <label for="availability-0">
                                                            <input name="availability" id="availability-0" value="1" checked="checked" type="radio">
                                                            Full time
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label for="availability-1">
                                                            <input name="availability" id="availability-1" value="2" type="radio">
                                                            Part Time
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Text input-->
                                            <div class="form-group">
                                                <label class="col-md-6 control-label" for="experience">Total Experience </label>  
                                                <div class="col-md-6">
                                                    <input id="experience" name="experience" placeholder="Experience in years" class="form-control input-md" required="" type="text">

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
                                name="savephoto" type="submit">Save Info</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--       Ending the form  --->

    <div class="panel-body" style="background : url('<?php echo base_url() ?>images/uploads/images.jpg') 50% 50% no-repeat;background-size: cover;">	

        <span  class='pull-right'>
            <ul id='socialbar'>
                <li><a href="http://www.facebook.com"  title="Become a fan"><img src="<?php echo base_url(); ?>images/social/facebook_32.png"  alt="Facebook" /></a></li>
                <li><a href="http://www.twitter.com" title="Follow our tweets"><img src="<?php echo base_url(); ?>images/social/twitter_32.png"  alt="Twitter" /></a></li>
                <li><a href="http://www.google.com"  title="Add to the circle"><img src="<?php echo base_url(); ?>images/social/google_plus_32.png" alt="Google Plus" /></a></li>
            </ul>

        </span>
        <div class='content-abt'>
            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="Networks">
                            <h5>Name:</h5>
                        </div>
                        <div class="col-md-4">                                               
                            <h5>SOMETHING</h5>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="gender">
                            <h5>Skills :</h5>
                        </div>
                        <div class="col-md-4">

                            <h5>do da da</a></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="bday">
                            <h5>Talent:</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>something</h5>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="language">
                            <h5>Contact:</h5>
                        </div>
                        <div class="col-md-4">

                            <h5>984389273</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="religion">
                            <h5>Address:</h5>
                        </div>
                        <div class="col-md-4">

                            <h5>something</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="religion">
                            <h5>Full-time/Part-time:</h5>
                        </div>
                        <div class="col-md-4">

                            <h5>Full-time</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-inline">
                <div class="rows">
                    <div class="col-md-8">
                        <div class="col-md-4" id="reldesc">
                            <h5>Total Exp:</h5>
                        </div>
                        <div class="col-md-4">

                            <h5><p>444<p></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
