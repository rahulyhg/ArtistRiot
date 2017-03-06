


<div class="well" id="well">
    <div class="panel-group" id="accordion">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?php
                    if ($is_my_profile)
                    {
                        ?>
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" title="What's on your mind?">
                            Update Status
                        </a>
                        <?php
                    }
                    else
                    {
                        ?>
                        My posts
                    <?php } ?>
                </h5>
            </div>

            <form action="save_post.php" method="POST">
                <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body">
                        <input type="hidden" name="comment_id" value="<?php //echo $_SESSION['member_id'];                     ?>">
                        <input type="hidden" name="author" value="<?php //echo $_SESSION['fName'] . ' ' . $_SESSION['lName'];                     ?>">
                        <input type="hidden" name="to" value="<?php //echo $_SESSION['member_id'];                     ?>">
                        <textarea class="form-control" name="content" placeholder="What's on your mind?"></textarea>

                    </div>
                    <div class="panel-footer" align="right">
                        <button class="btn btn-primary btn-sm" type="submit" name="share">Share</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table table-responsive" >
        <table border="0">
            <tr>
                <td rowspan="2" width="70px" height="70px"><img src="<?php echo base_url() ?>images/uploads/p.jpg" class="img-object" width="50px" height=50px" /></td>
                <td><strong><a href="#"> vatsal </a></strong> 

                    <br/><div style="font-size: 0.9em" ><p align="left">test content by vatsal</p></div>
                </td>
                <td><a href="#"><button type="button" class="close" aria-hidden="true">&times;</button></a></td>
            </tr>

            <tr>

                <td>
                    <table border="0">
                        <tr>
                            <td width="50px" height="50px"><img src="<?php echo base_url() ?>images/uploads/p.jpg" class="img-object" width="30px" height=40px" /></td>
                            <td><strong><a href="#"> vatsy </a></strong> 

                                <br/><div style="font-size: 0.9em" ><p align="left">test sub content by vatsy </p></div>
                            </td>
                            <td><a href="#"><button type="button" class="close" aria-hidden="true">&times;</button></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            <form action="#" method="post">
                <input name="commentid" type="hidden" value="">
                <input name="subauthor" type="hidden" value="">
                <td><img src="<?php echo base_url() ?>images/uploads/p.jpg" class="img-object" width="30px" height=30px" /></td>
                <td><input name="subcontent" type="text" style="width: 400px;" class="form-control input-sm" placeholder="Write a comment...">
            </form>
            </tr>
        </table>
    </div>

</div>
<div>
</div>
</tr>

</table>

<?php /*
  global $mydb;
  $mydb->setQuery("SELECT * from comments where comment_id=" . $_SESSION['member_id'] . " ORDER BY created DESC");
  $cur = $mydb->loadResultList();

  echo '<div class="table-responsive">';


  echo '<table border="0" class="table table-hover" >';

  echo '<tr>';
  foreach ($cur as $comm)
  {
  $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}' and pri='yes'");
  $propic = $mydb->loadResultList();
  if ($mydb->affected_rows() == 0)
  {
  echo '<td rowspan="2"><img src="./uploads/p.jpg" class="img-object" width="50px" height=60px" /></td>';
  }
  foreach ($propic as $obj)
  {
  echo '<td rowspan="2">';
  echo '<img src="./uploads/' . $obj->filename . '" class="img-object" width="50px" height="60px" />';
  echo '</td>';
  }

  echo '<td><strong><a href="home.php?id=' . $_SESSION['member_id'] . '">' . $comm->author . '</a></strong> ';

  echo '<br/><div style="font-size: 0.9em" ><p align="left">' . $comm->content . '</p><a>comment </a>' . date_toText($comm->created) . '</div>';
  echo '</td>';
  echo '<td><a href="delete_post.php?id=' . $comm->id . '"><button type="button" class="close" aria-hidden="true">&times;</button></a></td>';
  echo '</tr>';

  echo '<tr>';

  echo '<td>';
  echo '<table border="0">';

  // this area is for listing of sub-comment
  $mydb->setQuery("SELECT * FROM  `subcomment` WHERE `comment_id` = " . $comm->id);
  $sub = $mydb->loadResultList();
  foreach ($sub as $subcomm)
  {
  echo '<tr>';

  $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}' and pri='yes'");
  $propic = $mydb->loadResultList();
  if ($mydb->affected_rows() == 0)
  {
  echo '<td><img src="./uploads/p.jpg" class="img-object" width="30px" height=40px" /></td>';
  }
  foreach ($propic as $obj)
  {
  echo '<td >';
  echo '<img src="./uploads/' . $obj->filename . '" class="img-object" width="30px" height="40px" />';
  echo '</td>';
  }

  echo '<td><p><a href="home.php?id=' . $_SESSION['member_id'] . '">
  ' . $comm->author . '</a>  ' . $subcomm->subcontent . '</p><div style="font-size: 0.9em"><p>' . date_toText($subcomm->created) . '</p> </div></td>';
  echo '<td><a href="delete_sub.php?id=' . $subcomm->subc_id . '"><button type="button" class="close" aria-hidden="true">&times;</button></a></td>';
  echo '';
  echo '<tr>';
  echo '</tr>';
  echo '</tr>';
  }

  //This area is for creating a new comment

  echo '<tr>';
  echo '<form action="save_subcomm.php" method="post">';
  echo '<input name="commentid" type="hidden" value="' . $comm->id . '">';
  echo '<input name="subauthor" type="hidden" value="' . $_SESSION['fName'] . ' ' . $_SESSION['lName'] . '">';

  $mydb->setQuery("SELECT * FROM photos WHERE `member_id`='{$_SESSION['member_id']}' and pri='yes'");
  $propic = $mydb->loadResultList();
  if ($mydb->affected_rows() == 0)
  {
  echo '<td><img src="./uploads/p.jpg" class="img-object" width="30px" height=30px" /></td>';
  }
  foreach ($propic as $obj)
  {
  echo '<td >';
  echo '<img src="./uploads/' . $obj->filename . '" class="img-object" width="30px" height="30px" />';
  echo '</td>';
  }

  echo '<td><input name="subcontent" type="text" style="width: 400px;" class="form-control input-sm" placeholder="Write a comment...">';
  echo '</form>';
  echo '</tr>';
  echo '</table>';
  //echo '</div>';
  //  End of New sub comment.

  echo '</div>';

  echo '</div>'; //end of col-lg-6
  echo '</div>'; //end of row
  echo '</div>'; //end of well
  echo '</tr>';
  }
  echo '</table>';
 */ ?>
