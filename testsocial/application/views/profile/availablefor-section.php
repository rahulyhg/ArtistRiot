<div class="panel panel-success">
    <?php
    //  $mydb->setQuery("Select * from basic_info where member_id=" . $_SESSION['member_id']);
    // $info = $mydb->loadSingleResult();
    ?>
    <div class="panel-heading"><h3 class="panel-title">Availabe For  
            <?php
            if ($is_my_profile)
            {
                ?>
                <a data-target="#modal-edit-availfor" data-toggle="modal" href="" title=
                   "I am avilable for:"><span class="pull-right glyphicon glyphicon-edit">Edit</span></a>
               <?php } ?>
        </h3>
    </div>
    <div class="panel-body" id="tag-container">	

        <span class="glyphicon glyphicon-tag">option1</span>
        <span class="glyphicon glyphicon-tag">option1</span>
        <span class="glyphicon glyphicon-tag">option1</span>
        <span class="glyphicon glyphicon-tag">option1</span>
        <span class="glyphicon glyphicon-tag">option1</span>
        <span class="glyphicon glyphicon-tag">option1</span>
        <span class="glyphicon glyphicon-tag">option1</span>
        
        
        
        


    </div>

</div><!-- available for  -->

<!-- Modal -->
<div class="modal fade" id="modal-edit-availfor" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type=
                        "button">×</button>

                <h4 class="modal-title" id="myModalLabel">Check the options:</h4>
            </div>
            <form action="save_availfor_info.php" enctype="multipart/form-data" method=
                  "post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="rows">
                            <div class="col-md-12">
                                <div class="rows">
                                    <fieldset>

                                        
                                        <!-- Multiple Checkboxes -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="availablefor">Available For:</label>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <label for="availablefor-0">
                                                        <input name="availablefor" id="availablefor-0" value="1" type="checkbox">
                                                        Option one
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-1">
                                                        <input name="availablefor" id="availablefor-1" value="2" type="checkbox">
                                                        Option two
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-2">
                                                        <input name="availablefor" id="availablefor-2" value="3" type="checkbox">
                                                        Option three
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-3">
                                                        <input name="availablefor" id="availablefor-3" value="4" type="checkbox">
                                                        Option four
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-4">
                                                        <input name="availablefor" id="availablefor-4" value="5" type="checkbox">
                                                        Option five
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-5">
                                                        <input name="availablefor" id="availablefor-5" value="6" type="checkbox">
                                                        Option six
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-6">
                                                        <input name="availablefor" id="availablefor-6" value="7" type="checkbox">
                                                        Option seven
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-7">
                                                        <input name="availablefor" id="availablefor-7" value="8" type="checkbox">
                                                        Option eight
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-8">
                                                        <input name="availablefor" id="availablefor-8" value="9" type="checkbox">
                                                        Option nine
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="availablefor-9">
                                                        <input name="availablefor" id="availablefor-9" value="10" type="checkbox">
                                                        Option ten
                                                    </label>
                                                </div>
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
                            name="editavail" type="submit">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
