<?php
	

 $comment_id = $_POST['commentid'];
 $content = $_POST['subcontent'];
 $author = $_POST['subauthor'];
 $created =  strftime("%Y-%m-%d %H:%M:%S", time());


	global $mydb;
	$mydb->setQuery("INSERT INTO `philsocialdb`.`subcomment` (`subc_id`, `comment_id`, `subauthor`, `subcontent`, `created`) 
						VALUES (NULL, '{$comment_id}', '{$author}', '{$content}', '{$created}');");
	$mydb->executeQuery();
	
	if ($mydb->affected_rows() == 1) {
		
		echo "<script type=\"text/javascript\">
					//alert(\"Comment created successfully.\");
					window.location='home.php';
				</script>";
		
	} else{
		echo "<script type=\"text/javascript\">
					alert(\"Comment creation Failed!\");
				</script>";
	}


?>