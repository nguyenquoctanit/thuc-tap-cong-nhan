<head>
    <?php
    require('header.php');
    require('../library/config.php');
    header('Content-Type: text/html;charset=UTF-8');
    $username = $_GET['username'];
    $sql = "SELECT * FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result);
    ?>
    <title>Thêm chuyên mục</title>
    <!-- JavaScript -->
    <script>
        function editMember() {
        }
    </script>
</head>
<!--/JavaScript-->

<!--Phần chính phía bên phải-->
<main role="main">
    <section class="panel important">
        <h2>Chỉnh sửa thành viên </h2>
        <form name="editMember" id="editMember" method="POST" action="do_edit_member.php">
            <input type="hidden" name="old_username" value="<?php echo "$username"; ?>">
            <div class="twothirds">
                <table class='table table-bordered'>
                    <tr>
                        <td>Tên đăng nhập</td> <td> <input type="text" name="username" value="<?php echo "$row[username]"; ?>"  /></td>
                    </tr>
                    <tr>
                        <td>Mật khẩu</td> <td> <input type="password" name="password" value="<?php echo "$row[password]"; ?>"  /></td>
                    </tr>
                    <tr>
                        <td>Họ tên</td> <td> <input type="text" name="full_name" value="<?php echo "$row[full_name]"; ?>"  /></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td> <input type="email" name="email"  value="<?php echo "$row[email]"; ?>"   /></td>
                    </tr>
                    <tr>
                        <td>Tình trạng</td> <td> 
                            <select name="is_blocked">;
                                <option value='1'>Khóa</option>
                                <option value='0'>Không khóa</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Link Avatar</td> <td> <input type="text" name="avatar_url"  value="<?php echo "$row[avatar_url]"; ?> " /></td>
                    </tr>
                </table>	
            </div>
            <div class="onethird">
                <!--Thực hiện dropdown-->
                <label for="select-choice">Chức vụ:</label>
                <select name="level">;
                    <option value='0'>Admin</option>';
                    <option value='2'>Mod</option>';
                    <option value='4'>Member</option>';	
                </select>
                <!--Thực hiện dropdown-->
            </div>
            <div>
                <input type="submit" class="button3" width="50" class="btn btn-default" value="Save"/>
            </div>
            </div>
        </form>
    </section>
</main>
<footer role="contentinfo">Trang rao vặt - SE28</footer>

</body>
<!-- Out Body -->
</html>