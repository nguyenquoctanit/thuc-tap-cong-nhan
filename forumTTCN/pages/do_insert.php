<?php
session_start();
include('../library/function.php');
if (isset($_SESSION['session_is_blocked']) && $_SESSION['session_is_blocked'] == TRUE) {
    //die("Bạn không thể thực hiện chức năng này khi đang bị khóa tài khoản!");
    header('location: ../exit.php?result=blocked');
}
// Thực hiện các chức năng thêm mới
$mod = isset($_POST['mod']) ? $_POST['mod'] : "";
if ('post' == $mod) {
    $topic_id = $_POST['topic_id'];
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $username = $_SESSION['session_username'];
    // $preview_post = $_POST['preview_post'];
    $link_video = $_POST['link_video'];
    $time_video = $_POST['time_video'];
    if($_FILES['picture']['name'] != ''){
      $ar_ex_name = explode('.',$_FILES['picture']['name']);
      $tail_name = end($ar_ex_name);
      $new_name_pic = 'book-'.time().'.'.$tail_name;
      $tmp_name = $_FILES['picture']['tmp_name'];
      $path_upload = '../upload_images/'.$new_name_pic;
      $move_upload = move_uploaded_file($tmp_name,$path_upload);
    }
    $is_verified = 0;
    if ($_SESSION['session_level'] < LEVEL_MEMBER) {
        $is_verified = 1; // Admin, mod thì không cần duyệt lại bài
    }
    $insert_post = "insert into posts (topic_id,post_title, post_content,picture,video,time_video,username,is_verified) values($topic_id, '$post_title', '$post_content','$new_name_pic','$link_video','$time_video','$username', $is_verified)";
    //echo $insert_post;
    // đăng bài quá ngắn thì nghỉ
    if (mysqli_query($connection,$insert_post)) {
        //echo "Đã thêm bài viết thành công";
        header('location: ../cat.php?id=' . $topic_id.'&msg=Thêm bài viết thành công!');
    } else {
        //die("Thêm bài viết thất bại");
        header('location: ../exit.php?result=failed&message=Thêm bài viết thất bại');
    }
}else if ('reply' == $mod) {
    $post_id = $_POST['post_id'];
    $content = $_POST['content_reply'];
    $username = $_POST['username'];
    $insert_reply = "insert into replies (post_id,content,username) values($post_id, '$content', '$username')";
    if (mysqli_query($connection,$insert_reply)) {
        header('location: ../detail.php?post_id=' . $post_id.'&msg=Đăng bình luận thành công');
    } else {
        header('location: ../exit.php?result=failed&message=Phản hồi thất bại');
    }
} else if ('verification' == $mod) {
    
} else if ('block' == $mod) {
    
} else if ('user' == $mod) {
    $username = $_POST['username-register'];
    $full_name = $_POST['fullname-register'];
    $email = $_POST['email-register'];
    $password = $_POST['password-register'];
    $confirm_password = $_POST['re-password'];
    if ($password == $confirm_password){
        $insert_user = "insert into users(username, full_name, email, password) values('$username', '$full_name', '$email', '$password')";
        if (mysqli_query($connection,$insert_user)) {
            header("location: ../login.php?msg=Đăng kí thành công! Vui lòng đăng nhập để được tiếp tục!");
        } else {
            header("location: ../exit.php?result=failed&message=Không thể đăng kí thành viên <b>$username</b>");
        }
    } else {
        header('location: ../exit.php?result=failed&message=Mật khẩu nhập lại không khớp!');
    }
} else {
    die("Bùm");
}
?>