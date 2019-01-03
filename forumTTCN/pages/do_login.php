<?php
//FINISHED
include("../library/config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-login'])) {
    $myusername = $_POST['username-login'];
    $mypassword = $_POST['password-login'];
    $sql = "select * from users where username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($connection,$sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $_SESSION['session_username'] = $myusername;
        $_SESSION['session_full_name'] = $row['full_name'];
        $_SESSION['session_level'] = $row['level']; // Xem hắn là ai
        $_SESSION['session_is_blocked'] = $row['is_blocked']; // Xem hắn có bị khóa nick hay không?
        $login_time = date('Y-m-d G:i:s');
        $sql_2 = "update users set last_login_time= '$login_time' where username = '$myusername'";
        mysqli_query($connection,$sql_2);
        header("location:../index.php"); // Quay về trang chủ
    } else {
        header('location:../index.php?msg="Thất bại"');
    }
}
?>