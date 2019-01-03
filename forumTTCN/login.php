<?php 
	include('inc/header.php');
?>
    <!-- ##### Breadcrumb Area Start ##### -->
    <div class="vizew-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
                        </ol>
                    </nav>
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
                            <h4>Login Now!</h4>
                            <div class="line"></div>
                            <?php if(isset($_GET['msg'])){
                                echo '<p style="margin-top:10px;">'.$_GET["msg"].'</p>';
                            }?>
                        </div>
                        <form action="pages/do_login.php" method="post">
                            <div class="form-group">
                                <input type="text" name="username-login" class="form-control" id="username-login" placeholder="Vui lòng nhập username" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password-login" class="form-control" id="password-login" placeholder="Vui lòng nhập password" required="">
                            </div>
                            <button type="submit" class="btn vizew-btn w-100 mt-30" name="btn-login">Login</button>
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