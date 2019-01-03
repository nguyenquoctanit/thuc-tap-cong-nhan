<?php
session_start();
if (!isset($_SESSION['session_username']) || $_SESSION['session_level'] > 1) {
    header("location: ../exit.php?result=warning");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Trang Quản Lý Diễn Đàn</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/admincp.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/font-awesome.css" />
    </head>

    <body>
        <header role="banner">
            <h1>Trang Quản Lý</h1>
            <ul class="utilities">
                <li class="users"><a href="../">Đến trang chủ</a></li>
                <li class="logout warn"><a href="../pages/do_logout.php">Log Out</a></li>
            </ul>

        </header>

        <nav role='navigation'>
            <ul class="main">
                <li class="dashboard"><a href="index.php">Quản lý chung</a></li>
                <!--<li class="write"><a href="#">Bài đăng </a></li>-->
                <li class="edit"><a href="admintopic.php">Chuyên Mục</a></li>
                <li class="users"><a href="member.php">Thành viên</a></li>
                <!--<li class="banner"><a href="#">Banner</a></li>
                <li class="icon-envelop"><a href="#">Mail</a></li>-->
            </ul>
        </nav>