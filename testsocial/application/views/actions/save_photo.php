<?php
	

$upload_errors = array(
UPLOAD_ERR_OK	      => "No errors.",
UPLOAD_ERR_INI_SIZE	  => "Larger than upload_max_filesize.",
UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE.",
UPLOAD_ERR_PARTIAL	  => "Partial upload.",
UPLOAD_ERR_NO_FILE    => "No file.",
UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
UPLOAD_ERR_EXTENSION  => "File upload stopped by extension.",
);
if (isset($_POST['savephoto'])){
			
	 $tmp_file = $_FILES['upload_file']['tmp_name'];
	 @$target_file = basename($_FILES['upload_file']['name']);
	 $upload_dir = "uploads";
	 $imgsize = $_FILES['upload_file']['size'];	
	 $imgtype = $_FILES['upload_file']['type'];
	 $member_id = $_SESSION['member_id'];
	 	
	if ($imgtype == "image/jpeg") {
		
	if (move_uploaded_file($tmp_file,$upload_dir."/".$target_file)){
			global $mydb;
			
			$mydb->setQuery("UPDATE `photos` SET `pri`='no' WHERE   member_id ='{$member_id}'");
			$mydb->executeQuery();
			
			$mydb->setQuery("INSERT INTO `photos`(`filename`, `type`, `size`, `member_id`,`pri`) 
				VALUES ('{$target_file}', '{$imgtype}', '{$imgsize}', '{$member_id}','yes' )");
			$mydb->executeQuery();

			if ($mydb->affected_rows() == 1) {
				
				echo "<script type=\"text/javascript\">
							alert(\"Primary photo save.\");
							window.location='home.php';
						</script>";
				
			} else{
				echo "<script type=\"text/javascript\">
							alert(\"Prima photo uploading Failed!\");
						</script>";
			}
		
			//echo "File uploaded Succesfully";
			
		}else{
			$error = $_FILES['upload_file']['error'];
			$message = $upload_errors[$error];
			echo "<script type=\"text/javascript\">
							alert(\".{$message}.\");
							
						</script>";
		}
		
		} else {
		echo "<script type=\"text/javascript\">
							alert(\"Invalid Image format.\");
							window.location='home.php';
						</script>";
			
		
		}
	
}
?>