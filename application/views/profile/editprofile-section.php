<div class="" id="editProfile">
 <div class="well">
    <div class="row">
    
    <div class="col-md-3 col-sm-3 col-xs-12 text-center">
    	<ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#tab_a" data-toggle="pill">Update Profile</a></li>
            <li><a href="#tab_b" data-toggle="pill">Update Social Links</a></li>
            <li><a href="#tab_c" data-toggle="pill">Change Pasword</a></li>
        </ul>
    </div>
        
        
        <div class="tab-content col-md-7 col-sm-7 col-xs-12 ">
            <div class="tab-pane active " id="tab_a">
                <h4 >Update Profile</h4>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>

                            <tr >
                                <td style="width:25%"> First Name</td>
                                <td class="text-muted"> 
                                    <a href="#" id="editfirstname"><?php echo $this->session->userdata['first_name']; ?></a></td>
                            </tr>
                            <tr>
                                <td >Last Name</td>
                                <td class="text-muted">
                                    <a href="#" id="editlastname" ><?php echo $this->session->userdata['last_name']; ?></a></td>
                            </tr>
                            <tr>
                                <td >Email Address</td>
                                <td class="text-muted"><?php echo $userProfileData['email'] ?></td>
                            </tr>
                            <tr>
                                <td >Phone Number</td>
                                <td class="text-muted">
                                    <a href="#" id="editmobile" ><?php echo $userProfileData['phone'] ?></a></td>
                            </tr>
                            <tr>
                                <td >Type of Artist</td>
                                <td class="text-muted">
                                    <a href="#" id="editcategory" ><?php echo $userProfileData['category_name'] ?></a></td>
                            </tr>
                            <tr>
                                <td>Speciality</td>
                                <td class="text-muted">
                                    <a href="#" id="editsubcategory"><?php echo $this->session->userdata['sub_category_name']; ?></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pull-right">
                    <button type="button" id="updateprofilebutton" style="display: block; width: 100%;"
                            class="btn btn-default btn-primary col-md-6">Update</button>
                </div>

            </div>
            <div class="tab-pane" id="tab_b">

                <h4>Update Social Links</h4>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr >
                                <td style="width:25%">Facebook Link</td>
                                <td class="text-muted"> 
                                    <a href="#" id="editfblink"><?php echo $userProfileData['fb_link']; ?></a></td>
                            </tr>
                            <tr>
                                <td >Twitter Link</td>
                                <td class="text-muted">
                                    <a href="#" id="edittwitterlink" ><?php echo $userProfileData['twitter_link']; ?></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pull-right">
                    <button type="button" id="updateLinksButton" style="display: block; width: 100%;"
                            class="btn btn-default btn-primary col-md-6">Update</button>
                </div>
            </div>
            <div class="tab-pane" id="tab_c">

                <h4>Change Password</h4>

                <fieldset id="first" style="padding:0px;">


                    <div class="form-group update_error_message">
                        <p class="col-md-6 col-sd-8  col-md-offset-4 ">
                            <?php echo validation_errors(); ?></p>
                    </div>

                    <?php
                    $attributes = array(
                        'id' => 'updatePassword',
                        'data-toggle' => 'validator'
                    );
                    echo form_open('profile/editprofile/updatepassword', $attributes);
                    ?>

                    <div class="form-group" style='padding-bottom:45px;'>
                        <label for="password" class="col-md-5 control-label">Current Password *</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="crntpassword"
                                   name="crntpassword" placeholder="Curent Password">
                        </div>
                    </div>
                    <div class="form-group" style='padding-bottom:45px;'>
                        <label for="password" class="col-md-5 control-label">New Password *</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="newpassword"
                                   name="newpassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group " style='padding-bottom:45px;'>
                        <label for="password" class="col-md-5 control-label">Confirm Password *</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="cnfpassword"
                                   name="cnfpassword" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group" style='padding-top:0px;'>
                        <div class="col-md-offset-8 col-md-3">
                            <button type="submit" id="updatepassbuton" style="display: block; width: 100%;"
                                    class="btn btn-default btn-primary col-md-6">Submit</button>
                        </div>
                    </div>

                </fieldset>


                <?php
                echo form_close();
                ?>	
            </div>
        </div>


    </div><!-- tab content -->

</div>
</div>

