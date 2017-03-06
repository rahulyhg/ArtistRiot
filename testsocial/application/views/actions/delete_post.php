<?php

//set the delete statement statement specifying the id based on ID 
//pass through URL thats why we use the $_GET['id'] variable
$mydb->setQuery("DELETE FROM comments where id=".$_GET['id']);
//we execute the query
$mydb->executeQuery();
//we check if the affected rows during the deletion of data is equal to one
//meaning we succesfully delete the selected comment or post.
if($mydb->affected_rows() == 1){

	echo "<script type=\"text/javascript\">
		//alert(\"Comment Successfully deleted!.\");
		window.location='home.php';
	</script>";
}else{
	echo "<script type=\"text/javascript\">
		//alert(\"Comment deleted failed!.\");
		window.location='home.php';
	</script>";

}
?>