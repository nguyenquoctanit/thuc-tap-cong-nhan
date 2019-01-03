<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include("library/config.php");
include("library/function.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Halibi - Diễn đàn review sách, truyện...</title>
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/forum-main.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Top Header Area -->
        <div class="top-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-5">
                        <!-- Breaking News Widget -->
                        <div class="breaking-news-area d-flex align-items-center">
                            <div class="news-title">
                                <p>Diễn đàn:</p>
                            </div>
                            <div id="breakingNewsTicker" class="ticker">
                                <ul>
                                    <li><a href="#">Chào mừng bạn đến với diễn đàn review sách</a></li>
                                    <li><a href="#">Nơi giới thiệu đến bạn những quyển sách hay</a></li>
                                    <li><a href="#">Cập nhật xu hướng đọc sách thời đại</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="top-meta-data d-flex align-items-center">
                            <!-- Top Social Info -->
                            <!-- Top Search Area -->
                            <div class="top-search-area">
                                <form action="search.php" method="post">
                                    <input type="search" name="top-search" id="topSearch" placeholder="Search..." required="">
                                    <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                            <!-- Login -->
							<?php 
							if (isset($_SESSION['session_username'])){//Sử dụng isset() để kiểm tra biến session được thiết lập hay chưa.
							?>
							<div class="group-btn" style="margin-left:10px!important;">
                            <a href="user_panel.php" style="color:blue"><?= $_SESSION['session_full_name'] ?></a>&nbsp;
                            <?= ($_SESSION['session_level'] < LEVEL_MODERATOR ? '<a href="admincp/index.php" class="login-btn"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;AdminCP</a>' : '') ?>
                            &nbsp;<a href="pages/do_logout.php" class="login-btn"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Đăng xuất</a>
							</div>
							<?php
							// nếu chưa đăng nhập thì hiển thị form đăng nhập
							}else{ 
							?>
							<div class="group-btn">
                            <a href="login.php" class="login-btn"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Đăng nhập</a>
                            <a href="register.php" class="login-btn"><i class="fa fa-registered" aria-hidden="true"></i>&nbsp;Đăng kí</a>
							</div>
							<?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar Area -->
        <div class="vizew-main-menu" id="sticker">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">

                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="vizewNav">

                        <!-- Nav brand -->
                        <a href="index.php" class="nav-brand"><img src="img/core-img/logo-other.png" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="index.php">Trang chủ</a></li>
                                    <?php   $user_level = LEVEL_VISITOR;
                                    if (isset($_SESSION['session_username'])) {
                                        $user_level = $_SESSION['session_level'];
                                    }
                                      // Lấy danh sách mã các chuyên mục gốc đầu tiên
                                    $select_topics = 'select * from topics where parent_topic_id is null and level >= ' . $user_level;
                                    $result_topics = mysqli_query($connection,$select_topics);
                                    if ($result_topics){
                                    while ($row = mysqli_fetch_assoc($result_topics)){
                                    ?>
                                    <li>
                                    <a href="javascript:void(0)"><?php echo $row['topic_title']; ?></a>
                                    <?php
                                    // Lấy danh sách mã các chuyên mục gốc đầu tiên
                                    $select_child_topics = 'select * from topics where parent_topic_id = ' . $row['topic_id'] . ' and level >= ' . $user_level;
                                    $result_nested_topics = mysqli_query($connection,$select_child_topics);
                                    if ($result_nested_topics) {
                                    ?>    
                                    <ul class="dropdown">
                                    <?php    
                                    while ($nested_row = mysqli_fetch_assoc($result_nested_topics)){
                                    ?>
                                    <li><a href="cat.php?id=<?php echo $nested_row['topic_id']; ?>"><?php echo $nested_row['topic_title']; ?></a></li>
                                    <?php                                       
                                        }
                                    ?>   
                                    </ul>
                                    <?php 
                                    }
                                    ?> 
                                    </li>
                                   <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->