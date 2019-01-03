<?php

// Connects to your Database 
$username = $_POST['username'];
$password = $_POST['password'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$is_blocked = $_POST['is_blocked'];
$avatar_url = $_POST['avatar_url'];
$level = $_POST['level'];
session_start();
require("../library/config.php");
$sql = "INSERT INTO users(username, password, email, is_blocked, avatar_url, level, full_name) VALUES('$username','$password','$email','$is_blocked','$avatar_url', '$level', '$full_name')";
mysqli_query($connection,$sql);
Print "Thêm thành viên thành công";
header("location:search_member.php?namesearch=$username");
?>