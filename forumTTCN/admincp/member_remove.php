<?php

session_start();
require("../library/config.php");
$username = $_GET["username"];
//require("checkUser.php") 		
?>

<?php

$sql = "DELETE FROM users WHERE username ='$username'";
$result = mysqli_query($connection,$sql);
if ($result == 1) {
    header("location:member.php");
} else {
    header("location:abc.php");
}
?>