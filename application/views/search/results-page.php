<div class="container" style="margin-top: 0px;">
<div class="well-mod" style="box-shadow: 2px 2px 12px 1px #B5AEAE;">
    <?php
    if ($searchResultsData != '')
    {
        ?>
        <hgroup class="mb20">
            <h1 style="border-bottom: 2px solid #DFD7D5;"> Search Results</h1>
            <h2 class="lead"><strong class="text-danger"><?php echo sizeof($searchResultsData) ?></strong> results were found for the search for <strong class="text-danger"><?php echo $searchQuery ?></strong></h2>								
        </hgroup>

        
            <section class="col-xs-12 col-sm-6 col-md-12">
            <?php
        foreach ($searchResultsData as $searchData)
        {
            ?>
                <article class="search-result row">
                    <div id= "<?php echo $searchData['user_id'] ?>" class="col-xs-12 col-sm-12 col-md-2">
                        <?php
                        if ($searchData['user_image_path'] != '')
                        {
                            ?>
                            <a href="<?php echo base_url() . $searchData['role'] . '/' . $searchData['userName'] ?>" title="<?php echo $searchData['userName'] ?>" class="thumbnail">
                            	<img src="<?php echo $searchData['user_image_path'] ?>" class="img-thumbnail padding-0" 
                            	alt="<?php echo $searchData['userName'] ?>" width="100px" height="100px"/>
                            </a>
                        <?php
                        }
                        else
                        {
                            ?>
                            <a href="<?php echo base_url() . $searchData['role'] . '/' . $searchData['userName'] ?>" title="<?php echo $searchData['userName'] ?>" class="thumbnail"><img src="http://artistriot.com/artistriot/images/uploads/p.jpg" alt="<?php echo $searchData['userName'] ?>" width="275"/></a>  
                        <?php }
                        ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <ul class="meta-search">
                            <li><i class="glyphicon glyphicon-tags"></i> <?php echo $searchData['sub_category_name']?></li>
                            <li><i class="glyphicon glyphicon-star-empty"></i> <span class='stars_small' ><?php echo round($searchData['rating'],1)?></span></li>
                            <li><i class="glyphicon glyphicon-globe"></i> <?php echo $searchData['city'] ?> </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
                        <h3><a href="<?php echo base_url() . $searchData['role'] . '/' . $searchData['userName'] ?>" title="<?php echo $searchData['userName'] ?>"><?php echo $searchData['first_name'] . ' ' . $searchData['last_name'] ?></a></h3>
                        <p><?php echo $searchData['user_description'] ?></p>						
                    </div>
                    <span class="clearfix borda"></span>
                </article>

                <?php
            }
        }
        else
        {
            ?>

            <hgroup class="mb20">
                <h1>Search Results</h1>
                <h2 class="lead"><strong class="text-danger">No results were found for the search for <strong class="text-danger"><?php echo $searchQuery ?></strong></h2>								
            </hgroup>

        <?php } ?>		

    </section>
    </div>
</div>