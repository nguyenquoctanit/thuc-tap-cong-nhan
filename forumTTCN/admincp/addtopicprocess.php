<?php
// Connects to your Database 
$topic_title = $_POST['topic_title'];
$description = $_POST['description'];
$parent_topic_id = $_POST['parent_topic_id'];
session_start();
require("../library/config.php");
$sql;
if ($parent_topic_id == 'NULL') {
    $sql = "INSERT INTO topics(topic_title, description) VALUES('$topic_title','$description')";
} else {
    $sql = "INSERT INTO topics(topic_title, description, parent_topic_id) VALUES('$topic_title','$description','$parent_topic_id')";
}

mysqli_query($connection,$sql);
Print "Thêm chuyên mục thành công";
header("location:admintopic.php");
?>