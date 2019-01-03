<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include('../library/function.php');
// Người lạ miễn vào
if (!isset($_SESSION['session_username'])) {
    header('location: exit.php?result=warning');
} else if ($_SESSION['session_is_blocked'] == TRUE) {
    //die("Bạn không thể thực hiện chức năng này khi đang bị khóa tài khoản!");
    header('location: exit.php?result=blocked');
}
// Thực hiện các chức năng xóa
$mod = isset($_GET['mod']) ? $_GET['mod'] : "";
if ('post' == $mod) {
    $post_id = $_GET['post_id'];
    $delete_post = "delete from posts where post_id = $post_id";
    $delete_replies = "delete from replies where post_id = $post_id";
    if (mysqli_query($connection,$delete_post) && mysqli_query($connection,$delete_replies)) {
        header('location: ../index.php?result=success&message=Đã xóa bài viết cùng các phản hồi kèm theo!');
    } else {
        header('location: exit.php?result=failed&message=Không thể xóa bài viết!');
    }
} else if ('reply' == $mod) {
    $reply_id = $_GET['reply_id'];
    $post_id = $_GET['post_id'];
    $delete_reply = "delete from replies where reply_id = $reply_id";
    if (mysqli_query($connection,$delete_reply)) {
        header('location: ../detail.php?post_id=' . $post_id.'&msg=Đã xóa bình luận thành công');
    } else {
        header('location: exit.php?result=failed&message=Không thể xóa bài viết!');
    }
} else if ('block' == $mod) {
    
} else {
    die("Bùm");
}
?>