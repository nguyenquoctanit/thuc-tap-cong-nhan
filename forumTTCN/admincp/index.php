<?php
session_start();
if (!isset($_SESSION['session_username']) || $_SESSION['session_level'] > 1) {
    header("location: ../exit.php?result=warning");
}
require_once("../library/config.php");
?>
<!DOCTYPE html>
<html lang="en">
    <!--Phần Head chứa css và định dạng-->
    <?php
    require('header.php');
    ?>

    <!--Phần chính phía bên phải-->
    <main role="main">
        <!--Section đầu tiên, lời chào-->
        <section class="panel important">
            <h2>Xin chào đến với trang quản lý của ban quản trị </h2>
            <ul>
                <li>Chúc bạn một ngày tốt lành.</li>
            </ul>
        </section>
        <!--Section thứ 2, thông tin về tổng số tin rao-->
        <section class="panel">
            <h2>Tổng số Bài đăng</h2>
            <ul>
                <?php 
                $sql1 = "select * from posts";
                $query1 = mysqli_query($connection,$sql1);
                $record_count1 = mysqli_num_rows($query1);
                ?>
                <li><b><?php echo $record_count1; ?></b>&nbsp;Bài đăng</li>
                <?php 
                $sql2 = "select * from posts where is_verified = 0";
                $query2 = mysqli_query($connection,$sql2);
                $record_count2 = mysqli_num_rows($query2);
                ?>
                <li><b><?php echo $record_count2; ?></b>&nbsp;Bài chưa duyệt.</li> 
            </ul>
        </section>
    </main>
    <footer role="contentinfo">Diễn đàn cơ bản Quốc Tấn</footer>

</body>
<!-- Out Body -->
</html>