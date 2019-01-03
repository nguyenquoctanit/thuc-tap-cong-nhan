<?php

session_start();
require("../library/config.php");

//require("checkUser.php") 
?>

<?php

$sql = "UPDATE topics  SET  topic_title = '" . $_POST['topic_title'] . "', description = '" . $_POST['description'] . "', parent_topic_id = '" . $_POST['parent_topic_id'] . "'  WHERE topic_id ='" . $_POST['topic_id'] . "'";
$result = mysqli_query($connection,$sql);

if ($result == 1) {
    header("location:admintopic.php");
} else {
    header("location:abc.php");
}
?>