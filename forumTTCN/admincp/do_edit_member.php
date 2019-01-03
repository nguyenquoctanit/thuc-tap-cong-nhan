<?php

session_start();
require("../library/config.php");
$old_username = $_POST['old_username'];
$username = $_POST['username'];
$password = $_POST['password'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$is_blocked = $_POST['is_blocked'];
$avatar_url = $_POST['avatar_url'];
$level = $_POST['level'];
//require("checkUser.php") 
?>
<?php
$sql = "UPDATE users  SET  username = '$username', password = '$password', full_name = '$full_name',  email = '$email',  is_blocked = $is_blocked,  avatar_url = '$avatar_url', level = '$level'  WHERE username ='$old_username'";
$result = mysqli_query($connection,$sql);
if ($result == 1) {
    header("location:member.php?username=$username");
} else {
    header("location:abc.php");
}
?>