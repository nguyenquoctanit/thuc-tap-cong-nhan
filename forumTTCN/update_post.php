<?php
include('inc/header.php');
// include('library/function.php');
$post_id;
if (isset($_GET['post_id'])) {
    $post_id = (int) $_GET['post_id'];
    if ($post_id <= 0 || !isset($_SESSION['session_username']) || $_SESSION['session_is_blocked'] == TRUE) {
        //die ('Sai mã số bài viết, hoặc chưa đăng nhập, hoặc đã bị khóa nick!'); // BÙM!
        header('location: exit.php?result=failed');
    }
} else {
    //die ('Bạn chưa nhập mã số bài viết!'); // BÙM!
    header('location: exit.php?result=failed');
}
// Các thông tin cơ bản
$poster;
$post_title;
$post_content;
$picture;
$link_video;
$time_video;
// Đã lấy được mã số và kiểm đa sơ sơ ban đầu, tiếp tục kiểm tra xem có phải hàng chính chủ hay không
$select_post = "select posts.*, full_name from posts,users where post_id = $post_id and posts.username=users.username";
$result_select_post = mysqli_query($connection,$select_post);
if ($result_select_post) {
    if ($row_post = mysqli_fetch_array($result_select_post)) {
        $poster = $row_post['username'];
        // Tiếp tục kiểm tra xem có phải hàng chính chủ hay không
        if ($_SESSION['session_level'] >= LEVEL_MEMBER && $poster != $_SESSION['session_username']) {
            //die('Bạn không có quyền sửa bài viết này!');
            header('location: exit.php?result=failed');
        }
        $post_title = $row_post['post_title'];
        $post_content = $row_post['post_content'];
        $picture = $row_post['picture'];
        $link_video = htmlspecialchars($row_post['video']);
        $time_video = $row_post['time_video'];
    }
}
?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="vizew-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                </div>
            </div>
        </div>
    </div>
<section class="contact-area mb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-8">
                    <!-- Section Heading -->
                    <div class="section-heading style-2">
                        <h4>Sửa bài viết</h4>
                        <div class="line"></div>
                    </div>  
                    <!-- Contact Form Area -->
                    <div class="contact-form-area mt-50">
                        <form action="pages/do_update.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" name="mod" value="post">
                                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                <input type="hidden" name="poster" value="<?= $poster ?>">
                            </div>
                            <div class="form-group">
                                <label for="post_title">Tiêu đề bài viết*</label>
                                <input type="text" name="post_title" class="form-control" id="post_title" value="<?php echo $post_title; ?>">
                            </div>
                            <?php
                            if($picture!= ""){
                            ?>
                            <div class="form-group">
                                <label>Hình ảnh cũ</label><br />
                                <img src="upload_images/<?php echo $picture; ?>" alt="<?php $picture; ?>" width="100px" height="auto"><br />
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                      <input type="checkbox" class="form-check-input" name="check_picture"> Xóa ảnh
                                    <i class="input-helper"></i></label>
                                </div>
                            </div>
                            <?php
                                }else{
                                ?>
                                <strong style="color:red">Không có hình!</strong>
                                <?php
                                }
                            ?>
                            <div class="form-group">
                                <label for="picture">Hình ảnh bài viết*</label>
                                <input type="file" name="new_picture" id="picture">
                            </div>  
                            <div class="form-group">
                                <label for="post_content">Nội dung bài viết*</label>
                                <textarea name="post_content" class="form-control ckeditor" id="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="link_video">Link nhúng video</label>
                                <input type="text" name="link_video" class="form-control" id="link_video" value="<?php echo $link_video; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="time_video">Thời lượng video</label>
                                <input type="text" name="time_video" class="form-control" id="time_video" value="<?php echo $time_video; ?>" />
                            </div>                        
                            <button class="btn vizew-btn mt-30" type="submit" name="btn-submit">Đăng bài viết</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </section>     
<?php
include('inc/footer.php');
?>