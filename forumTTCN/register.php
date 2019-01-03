<?php 
	include('inc/header.php');
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
                            <h4>Register</h4>
                            <div class="line"></div>
                        </div>
                        <form action="pages/do_insert.php" method="post">
                            <input type="hidden" name="mod" value="user">
                            <div class="form-group">
                                <input type="text" name="username-register" class="form-control" id="username-register" placeholder="Vui lòng nhập username" required="">
                            </div>              
							<div class="form-group">
                                <input type="text" name="fullname-register" class="form-control" id="fullname-register" placeholder="Vui lòng nhập họ tên" required="">
                            </div>                            
							<div class="form-group">
                                <input type="email" name="email-register" class="form-control" id="email-register" placeholder="Vui lòng nhập email" required="">
                            </div>                            
							<div class="form-group">
                                <input type="password" name="password-register" class="form-control" id="password-register" placeholder="Vui lòng nhập password" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="re-password" class="form-control" id="re-password" placeholder="Vui lòng nhập lại password" required="">
                            </div>
                            <button type="submit" class="btn vizew-btn w-100 mt-30" name="btn-register">Register</button>
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