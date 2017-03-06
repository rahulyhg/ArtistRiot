


<div class="panel panel-success" id="testimonial-panel">
    <div class="panel-heading">
        <h3 class="panel-title">Testimonials<small> - See what people have to say about me.!
                <a data-target="#addReviewModal" data-toggle="modal" href="" title=
                   "Click here to ad your reviews."><i class="glyphicon glyphicon-plus-sign pull-right">Add-Review</i></a></small></h3></div>

    <div class="panel-body">
        <div class="carousel slide" id="testimonials-rotate">
          <!--  <ol class="carousel-indicators">
                <li class="active" data-slide-to="0" data-target="#testimonials-rotate">
                </li>
                <li data-slide-to="1" data-target="#testimonials-rotate">
                </li>
                <li data-slide-to="2" data-target="#testimonials-rotate">
                </li>
            </ol>-->
            <div class="carousel-inner">
                <div class="item active">	
                    <div class="col-md-2"><img alt="" src="http://lorempixel.com/400/200" class="img-circle img-responsive"/></div>
                    <div class="testimonials col-md-10">

                        <h3>
                            This guy is an awesome performer. He made my day. Simply brilliant. - <small>ooh la la</small>
                        </h3>

                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="item">	
                    <div class="col-md-2"><img alt="" src="http://lorempixel.com/400/200" class="img-circle img-responsive"/></div>
                    <div class="testimonials col-md-10">

                        <h3>
                            I think I love in love with him. - <small>Some girl</small>
                        </h3>

                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="item">
                    <div class="col-md-2"><img alt="" src="http://lorempixel.com/400/200" class="img-circle img-responsive"/></div>
                    <div class="testimonials col-md-10">

                        <h3>
                            Not as good as they say. Fucking asshole!! - <small>vatsal</small>
                        </h3>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a class="left" href="#testimonials-rotate" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right" href="#testimonials-rotate" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a><div class="clearfix"></div>	
        </div>


        <div class="clearfix"></div>
        
        <!-- Modal -->
        <div class="modal fade" id="addReviewModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type=
                                "button">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add your comment and rate your artist!!</h4>
                    </div>

                    <form action="save_review.php" enctype="multipart/form-data" method=
                          "post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="rows">
                                    <div class="col-md-12">
                                        <div class="rows">
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="reviewComment" placeholder="Write your review here..."></textarea>
                                            </div>

                                            <div class="col-md-4"><div id="star">
                                                    <input type="hidden" id="reviewScore" name="reviewScore" value="">
                                                </div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type=
                                    "button">Close</button> <button class="btn btn-primary"
                                    name="savereview" type="submit">Save Review</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div>
</div>