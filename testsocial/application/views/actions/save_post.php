

    <?php
    require_once("includes/initialize.php");	
     
    $comment_id = $_POST['comment_id'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $destination = $_POST['to'];
    $created = strftime("%Y-%m-%d %H:%M:%S", time());
     
     
    global $mydb;
    $mydb->setQuery("INSERT INTO `philsocialdb`.`comments` (`id`, `comment_id`, `content`, `author`, `to`, `created`)
    VALUES (NULL, '{$comment_id}', '{$content}', '{$author}', '{$destination}', '{$created}');");
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
     
     
    ?>F