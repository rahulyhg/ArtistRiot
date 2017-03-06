<?php

$mydb->setQuery("DELETE FROM subcomment where subc_id=".$_GET['id']);
$mydb->executeQuery();
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