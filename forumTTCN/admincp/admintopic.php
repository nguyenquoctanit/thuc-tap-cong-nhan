<?php
require_once("../library/config.php");
require_once("header.php");
ob_start();
?>

<script src="../js/jquery-latest.js"></script>
<main role="main">
    <section class="panel important">
        <h2>Quản lý chuyên mục</h2>
        <form action="searchtopic.php" method="POST" name="searchtopic">
            <div class="onethird"></div>
            <div style="text-align: center" class="onethird">
                <label for="name">Tên chuyên mục:</label> <input type="text"
                                                                 name="namesearch" id="namesearch"  /> </br>
            </div>
            <div style="text-align: center" class="onethird">
                </br> <input type="submit" value="Tìm kiếm" />
            </div>

            <!-- Bảng hiển thị tìm kiếm topic -->
            <?php
            $sql1 = "select * from topics";
            $query1 = mysqli_query($connection,$sql1);
            $stt = 0;
            echo "<table class='table table-bordered'><tr>";
            echo "<th>STT</th>	<th>ID</th>	<th>Tên chuyên mục</th>	<!--<th>Mô tả</th>-->	<th>Chuyên mục cha</th>	<th>Thao tác </th>";
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
                    //echo "<td>$row1[description]</td>";
                    echo "<td>$row2[topic_title] </td>";
                    echo "<td><a href='edittopic.php?topic_id=$row1[topic_id]'>Sửa|</a>";
                    echo "<a href='deletetopics.php?topic_id=$row1[topic_id]'>Xóa</a></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            ?>

            <div class="container">
                <div class="col-xs-4 col-xs-offset-4">
                    <a href="adminaddtopic.php" type="button" class="btn btn-success btn-block">Thêm chuyên mục</a>
                    <br>
                </div>
            </div>

        </form>
    </section>

</main>
<footer role="contentinfo">Diễn đàn cơ bản Quốc Tấn</footer>

</body>
<!-- Out Body -->
</html>