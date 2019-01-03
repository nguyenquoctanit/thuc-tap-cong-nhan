<?php
require_once("header.php");
require("../library/config.php");
ob_start();
$idsearch = $_POST['namesearch'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Trang Quản Lý</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/admincp.css" rel="stylesheet">

        <script>
            function addtopic() {

                window.open("adminaddtopic.php", "_self");
            }

        </script>

    </head>

    <body>
        <header role="banner">
            <h1>Trang Quản Lý</h1>
            <ul class="utilities">
                <li class="users"><a href="#">Đến trang chủ</a></li>
                <li class="logout warn"><a href="adminlogin.html">Log Out</a></li>
            </ul>

        </header>

        <nav role='navigation'>
            <ul class="main">
                <li class="dashboard"><a href="index.php">Quản lý chung</a></li>
                <li class="write"><a href="#">Bài đăng</a></li>
                <li class="edit"><a href="admintopic.php">Chuyên Mục</a></li>
                <li class="users"><a href="#">Thành viên</a></li>
                <!--<li class="banner"><a href="#">Banner</a></li>
                <li class="icon-envelop"><a href="#">Mail</a></li>-->
            </ul>
        </nav>

        <main role="main">

            <section class="panel important">
                <h2>Quản lý chuyên mục</h2>
                <form action="searchtopic.php" method="POST" name="searchtopic">
                    <div class="onethird">
                    </div>
                    <div style="text-align:center" class="onethird">
                        <label for="name">Tên chuyên mục:</label>
                        <input  type="text" name="namesearch" id="namesearch" placeholder="<?php echo $idsearch; ?>"  />
                        </br>
                    </div>
                    <div style="text-align:center" class="onethird">
                        </br>
                        <input type="submit" value="Tìm kiếm" />
                    </div>

                    <!-- Bảng hiển thị tìm kiếm topic -->
                    <?php
                    $sql1 = "select * from topics where topic_title like '%" . $idsearch . "%'";
                    $query1 = mysqli_query($connection,$sql1);
                    $stt = 0;
                    echo "<table class='table table-bordered'><tr>";
                    echo "<th>STT</th>	<th>ID Danh Mục</th>	<th>Ten Danh Muc</th>	<th>Mieu ta</th>	<th>Danh mục cha </th>	<th>Thao tác </th>";
                    echo "</tr>";
                    while ($row1 = mysqli_fetch_array($query1)) {
                        $sql2 = "select * from topics where topic_id = '$row1[parent_topic_id]'";
                        $query2 = mysqli_query($connection,$sql2);
                        while ($row2 = mysqli_fetch_array($query2)) {
                            $stt++;
                            echo "<tr>";
                            echo "<td>$stt</td>";
                            echo "<td>$row1[topic_id]</td>";
                            echo "<td>$row1[topic_title]</td>";
                            echo "<td>$row1[description]</td>";
                            echo "<td>$row2[topic_title] </td>";
                            echo "<td><a href='edittopic.php?topic_id=$row1[topic_id]'>Sửa</a></td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                    ?>	 
                    <!-- Nút thêm topic -->
                    <div class="row">
                    <div class="col-sx-12 col-md-4 col-md-offset-4 ">
                    <input type="button" class="btn btn-success btn-block"  onclick="addtopic()"  value="Thêm chuyên mục"/>
                    </div>
                    </div>
                    </br>
                </form>
            </section>

        </main>
        <footer role="contentinfo">Quốc Tấn</footer>

    </body>
    <!-- Out Body -->
</html>