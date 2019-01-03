<?php 
	include('inc/header.php');
    $get_username = $_SESSION['session_username'];
    $sql = "SELECT * FROM users WHERE username = '$get_username'";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result);
    $picture = $row['avatar_url'];
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

    <!-- ##### Login Area Start ##### -->
    <div class="vizew-login-area section-padding-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="login-content">
                        <!-- Section Title -->
                        <div class="section-heading">
                            <h4>Thông tin cá nhân!</h4>
                            <div class="line"></div>
                        </div>
                        <form action="pages/do_update.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="mod" value="user">
                            <div class="form-group">
                                <input type="hidden" value="<?php echo $_SESSION['session_username']; ?>" name="username"/>
                                <label>Tên tài khoản</label>
                                <input type="text" name="" readonly value="<?php echo $_SESSION['session_username']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="full_name">Họ và tên</label>
                                <input type="text" name="full_name" class="form-control" id="full_name" value="<?php echo $row['full_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $row['email']; ?>">
                            </div>
                            <?php
                            if($picture!= ""){
                            ?>
                            <div class="form-group">
                                <label>Hình ảnh cũ</label><br />
                                <img src="upload_images/user_images/<?php echo $picture; ?>" alt="<?php echo $picture; ?>" width="100px" height="auto"><br />
                            </div>
                            <?php
                                }else{
                                ?>
                                <strong style="color:red">Không có hình!</strong>
                                <?php
                                }
                            ?>
                            <div class="form-group">
                                <label for="picture">Hình ảnh đại diện mới*</label>
                                <input type="file" name="new_url" id="picture">
                            </div> 
                            <button type="submit" class="btn vizew-btn w-20 " name="btn-login" id="btn-center">Lưu thông tin</button>
                        </form>
                    </div>
                </div>
                     <div class="col-12 col-md-6">
                    <div class="login-content">
                        <!-- Section Title -->
                        <div class="section-heading">
                            <h4>Đổi mật khẩu!</h4>
                            <div class="line"></div>
                        </div>
                        <form action="pages/do_update.php" method="post">
                            <input type="hidden" name="mod" value="change_password">
                            <div class="form-group">
                                <label for="old_password">Mật khẩu cũ</label>
                                <input type="password" name="old_password" class="form-control" id="old_password" placeholder=" Vui lòng nhập mật khẩu cũ" required="">
                            </div>
                            <div class="form-group">
                                <label for="new_password">Mật khẩu mới</label>
                                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Vui lòng nhập mật khẩu mới" required="">
                            </div>
                            <div class="form-group">
                                <label for="re_password">Nhập lại</label>
                                <input type="password" name="re_password" class="form-control" id="re_password" placeholder="Vui lòng nhập lại mật khẩu mới" required="">
                            </div>
                            <button type="submit" class="btn vizew-btn w-20" name="btn-login" id="btn-center">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Login Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
<?php
	include('inc/footer.php');
?>