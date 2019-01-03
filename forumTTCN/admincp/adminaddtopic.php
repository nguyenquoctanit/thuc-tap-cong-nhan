<head>
    <?php
    require('header.php');
    require('../library/config.php');
    header('Content-Type: text/html;charset=UTF-8');
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

    <!--Phần chính phía bên phải-->
<main role="main">
    <section class="panel important">
        <h2>Thêm chuyên mục </h2>
        <form name="addTopic" id="addTopic" method="POST" action="addtopicprocess.php">
            <div class="twothirds">
                <label for="name">Tên chuyên mục:(*)</label>
                <p id="topicnamealert" style="color:red;"></p>
                <input type="text" name="topic_title" id="topic_title"  />
                <label for="textarea" id="des">Miêu tả chuyên mục:(*)</label>
                <p id="topicdesalert" style="color:red;"></p>
                <textarea cols="40" rows="8" name="description" ></textarea>
            </div>
            <div class="onethird">
                <!--Thực hiện dropdown-->
                <?php
                $query = mysqli_query($connection,"SELECT * FROM topics");

                echo '<label for="select-choice">Chọn chuyên mục cha:</label>';
                echo '<select name="parent_topic_id">';
                while ($row = mysqli_fetch_array($query)) {
                    echo '<option value="' . $row['topic_id'] . '">' . $row['topic_title'] . '</option>';
                }
                echo '<option selected="selected" value="NULL">Không</option>';
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
<footer role="contentinfo"></footer>

</body>
<!-- Out Body -->
</html>