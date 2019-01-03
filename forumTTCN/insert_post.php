<?php
include('inc/header.php');
$topic_id;
if (isset($_GET['insert_id'])) {
    $topic_id = (int) $_GET['insert_id'];
    if ($topic_id <= 0) {
        header("location: index.php"); // Quay về trang chủ nếu không nhập đúng số
    }
} else {
    header("location: index.php");
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
    <!-- ##### Breadcrumb Area End ##### -->
<section class="contact-area mb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-8">
                    <!-- Section Heading -->
                    <div class="section-heading style-2">
                        <h4>Đăng bài viết mới</h4>
                        <div class="line"></div>
                    </div>	
                    <!-- Contact Form Area -->
                    <div class="contact-form-area mt-50">
                        <form action="pages/do_insert.php" method="post" enctype="multipart/form-data">
                        	<div class="form-group">
                            	<input type="hidden" name="mod" value="post">
				                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				                <input type="hidden" name="username" value="<?= (isset($_SESSION["session_username"]) ?: '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="post_title">Tiêu đề bài viết*</label>
                                <input type="text" name="post_title" class="form-control" id="post_title">
                            </div>
							<div class="form-group">
								<label for="picture">Hình ảnh bài viết*</label>
								<input type="file" name="picture" id="picture">
							</div>	
                            <div class="form-group">
                                <label for="post_content">Nội dung bài viết*</label>
                                <textarea name="post_content" class="form-control ckeditor" id="post_content" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                            	<label for="link_video">Link nhúng video</label>
                            	<input type="text" name="link_video" class="form-control" id="link_video" />
                            </div>
                            <div class="form-group">
                            	<label for="time_video">Thời lượng video</label>
                            	<input type="text" name="time_video" class="form-control" id="time_video" />
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