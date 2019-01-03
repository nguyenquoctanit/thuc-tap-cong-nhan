<?php
require_once("../library/config.php");
require_once("header.php");
$idsearch = $_POST['namesearch'];
ob_start();
?>

<script src="http://code.jquery.com/jquery-latest.js">



</script>



<main role="main">
    <section class="panel important">
        <h2>Quản lý thành viên</h2>
        <form action="search_member.php" method="POST" name="searchtopic">
            <div class="onethird"></div>
            <div style="text-align: center" class="onethird">
                <label for="name">Tên thành viên:</label> <input type="text"
                                                                 name="namesearch" id="namesearch"  /> </br>
            </div>
            <div style="text-align: center" class="onethird">
                </br> <input type="submit" value="Tìm kiếm" />
            </div>

            <!-- Bảng hiển thị tìm kiếm topic -->
            <?php
            $sql1 = "select * from users where username like '%" . $idsearch . "%'";
            $query1 = mysqli_query($connection,$sql1);
            $stt = 0;
            echo "<table class='table table-bordered'><tr>";
            echo "<th>STT</th> <th>Tên đăng nhập<th>Họ tên</th>	<th>Email</th>	<th>Tình trạng khóa</th> <th>Cấp bậc</th> <th>Thao tác </th>";
            echo "</tr>";
            while ($row1 = mysqli_fetch_array($query1)) {

                $stt++;
                echo "<tr>";
                echo "<td>$stt</td>";
                echo "<td>$row1[username]</td>";
                echo "<td>$row1[full_name]</td>";
                echo "<td>$row1[email]</td>";
                if ($row1['is_blocked'] == 0) {
                    echo "<td>Không khóa</td>";
                } else{
                    echo "<td>Khóa</td>";
                }
                if ($row1['level'] == 0) {
                    echo "<td>Admin</td>";
                } else if ($row1['level'] == 2)
                    echo "<td>Mod</td>";
                else if ($row1['level'] == 4)
                    echo "<td>Member</td>";
                echo "<td><a href='edit_member.php?username=$row1[username]'>Sửa|</a>";
                echo "<a href='member_remove.php?username=$row1[username]'>Xóa</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
            <!-- Nút thêm topic -->
            <div class="container">	
                <div class="row">
                <div class="col-sx-12 col-md-4 col-md-offset-4 ">
                <a href="admin_add_member.php"><input type="button" class="btn btn-success"
                                                      value="Thêm thành viên" /> </br></a>
                </div>
                </div>                                      
            </div>

        </form>
    </section>

</main>
<footer role="contentinfo">Quốc Tấn</footer>

</body>
<!-- Out Body -->
</html>