<head>
    <?php
    require('header.php');
    require('../library/config.php');
    header('Content-Type: text/html;charset=UTF-8');
    $topic_id = $_GET["topic_id"];
    $sql = "SELECT * FROM topics WHERE topic_id = '$topic_id' ";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result);
    ?>
    <title>Thêm chuyên mục</title>
    <!-- JavaScript -->
    <script>
        function addtopic1() {

            ten = document.addTopic.topic_title.value;
            mieuta = document.addTopic.description.value;

            if (ten == "")
            {
                document.getElementById("topicnamealert").innerHTML = 'Không được để trống tên chuyên mục, vui lòng nhập lại!';
            } else
            if (mieuta == "")
            {
                document.getElementById("topicdesalert").innerHTML = 'Miêu tả chuyên mục không được để trống';
            } else

            {
                document.getElementById("addTopic").submit();
            }
        }




    </script>


</head>
<!--/JavaScript-->

<body>
    <!--Phần Banner trên cùng-->
    <header role="banner">
        <h1>Trang Quản Lý  </h1>		
        <ul class="utilities">
            <li class="users"><a href="#">Đến trang chủ</a></li>
            <li class="logout warn"><a href="adminlogin.php">Log Out</a></li>
        </ul>
    </header>

    <!--Phần Navigation phía bên trái-->
    <nav role='navigation'>
        <ul class="main">
            <li class="dashboard"><a href="admincp.php">Quản lý chung</a></li>
            <!--<li class="write"><a href="#">Bài Viết</a></li>-->
            <li class="edit"><a href="admintopic.php">Chuyên Mục</a></li>
            <li class="users"><a href="#">Thành viên</a></li>
            <!--<li class="banner"><a href="#">Banner</a></li>
            <li class="icon-envelop"><a href="#">Mail</a></li>-->
        </ul>
    </nav>

    <!--Phần chính phía bên phải-->
    <main role="main">
        <section class="panel important">
            <h2>Sửa chuyên mục </h2>
            <form name="addTopic" id="addTopic" method="POST" action="edittopicprocess.php">
                <input type="hidden" value="<?php echo "$topic_id"; ?>" name="topic_id" />
                <div class="twothirds">
                    <label for="name">Tên chuyên mục:(*)</label>
                    <p id="topicnamealert" style="color:red;"></p>
                    <input type="text" name="topic_title" id="topic_title" value="<?php echo "$row[topic_title]"; ?>" />
                    <label for="textarea" id="des">Miêu tả chuyên mục:(*)</label>
                    <p id="topicdesalert" style="color:red;"></p>
                    <textarea cols="40" rows="8" name="description" ><?php echo $row['description']; ?></textarea>
                </div>
                <div class="onethird">
                    <!--Thực hiện dropdown-->
                    <?php
// Connects to your Database 

                    $query1 = mysqli_query($connection,"SELECT * FROM topics");

                    echo '<label for="select-choice">Chọn chuyên mục cha:</label>';
                    echo '<select name="parent_topic_id">'; // Open your drop down box
// Loop through the query results, outputing the options one by one
                    while ($row1 = mysqli_fetch_array($query1)) {
                        if ($topic_id == $row1['topic_id']) {
                            
                        } else
                        if ($row1['topic_id'] == $row['parent_topic_id']) {
                            echo '<option selected="selected" value="' . $row1['topic_id'] . '">' . $row1['topic_title'] . '</option>';
                        } else {
                            echo '<option value="' . $row1['topic_id'] . '">' . $row1['topic_title'] . '</option>';
                        }
                    }

                    echo '</select>';
                    ?>
                    <!--Thực hiện dropdown-->
                </div>
                <div>
                    <input type="button" onclick="addtopic1()" class="button3" width="50" class="btn btn-default" value="Submit"/>
                </div>
                </div>
            </form>
        </section>
    </main>
    <footer role="contentinfo">Trang rao vặt - SE28</footer>

</body>
<!-- Out Body -->
</html>