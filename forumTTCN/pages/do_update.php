<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include('../library/function.php');
// Người lạ miễn vào
if (!isset($_SESSION['session_username'])) {
    header('location: exit.php?result=warning');
} else if ($_SESSION['session_is_blocked'] == TRUE) {
    //die("Bạn không thể thực hiện chức năng này khi đang bị khóa tài khoản!");
    header('location: ../exit.php?result=blocked');
}
// Thực hiện các chức năng cập nhật
$mod = isset($_POST['mod']) ? $_POST['mod'] : (isset($_GET['mod']) ? $_GET['mod'] : "");
if ('post' == $mod) {
    $poster = $_POST['poster'];
    $post_id = $_POST['post_id'];
    $post_title = $_POST['post_title'];
    // $preview_post = $_POST['preview_post'];
    $post_content = $_POST['post_content'];
    $link_video = $_POST['link_video'];
    $time_video = $_POST['time_video'];
    $check_picture = $_POST['check_picture'];
    $new_name;
    $sql_picture = "SELECT picture FROM posts WHERE post_id = $post_id ";
    $result = mysqli_query($connection,$sql_picture);
    while($row_picture = mysqli_fetch_assoc($result)){
        $new_name = $row_picture['picture'];
    }
    if($check_picture || $_FILES['new_picture']['name'] != ''){
    unlink('../upload_images/'.$new_name);
    $new_name = "";
    }
    if($_FILES['new_picture']['name'] != ''){
      $ar_ex_name = explode('.',$_FILES['new_picture']['name']);
      $tail_name = end($ar_ex_name);
      $new_name = 'book-'.time().'.'.$tail_name;
      $tmp_name = $_FILES['new_picture']['tmp_name'];
      $path_upload = '../upload_images/'.$new_name;
      $move_upload = move_uploaded_file($tmp_name,$path_upload);
    }
    $updated_time = date('Y-m-d G:i:s');
    $update_post = "update posts set post_title = '$post_title',post_content='$post_content',picture='$new_name',video = '$link_video',time_video='$time_video',last_edit_time = '$updated_time' where post_id = $post_id";
    if (mysqli_query($connection,$update_post)) {
        //echo "Đã cập nhật thành công";
        header('location:../index.php?result=success&msg=Đã sửa bài viết thành công');
    } else {
        //die("cập nhật thất bại");
        header('location: ../exit.php?result=failed');
    }
} else if ('reply' == $mod) {
} else if ('verifying' == $mod) {
    if ($_SESSION['session_level'] < LEVEL_MEMBER){
        $post_id = $_GET['post_id'];
        $update_post = "update posts set is_verified = 1 where post_id = $post_id";
        if (mysqli_query($connection,$update_post)) {
            header('location:../detail.php?post_id=' . $post_id);
        } else {
            header('location: exit.php?result=failed');
        }
    }else{
        header('location: ../exit.php?result=warning');
    }
} else if ('user' == $mod) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $name_url;
    $sql_avatar = "SELECT avatar_url FROM users WHERE username = '$username' ";
    $result_avatar = mysqli_query($connection,$sql_avatar);
    while($row_avatar = mysqli_fetch_assoc($result_avatar)){
        $name_url = $row_avatar['avatar_url'];
    }
    if($_FILES['new_url']['name'] != ''){
    unlink('../upload_images/user_images/'.$name_url);
    $name_url = "";
    }
    if($_FILES['new_url']['name'] != ''){
      $ar_ex_name = explode('.',$_FILES['new_url']['name']);
      $tail_name = end($ar_ex_name);
      $name_url = 'user-'.time().'.'.$tail_name;
      $tmp_name = $_FILES['new_url']['tmp_name'];
      $path_upload = '../upload_images/user_images/'.$name_url;
      $move_upload = move_uploaded_file($tmp_name,$path_upload);
    }
    $update_user = "update users set email = '$email', full_name='$full_name',avatar_url='$name_url' where username = '$username'";
    if (mysqli_query($connection,$update_user)) {
        header('location: ../user_panel.php?result='.$name_url);
    } else {
        header('location: ../exit.php?result=failed');
    }
} else if ('change_password' == $mod) {
    $get_username = $_SESSION['session_username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['re_password'];
    $change_password = "update users set password = '$new_password' where username = '$get_username' and password= '$old_password'";
    if ($new_password == $new_password_confirm && mysqli_query($connection,$change_password)) {
        header('location: ../user_panel.php?result=success');
    } else {
        header('location: ../exit.php?result=failed');
    }
}else {
    die("Bùm");
}
?>