<head>
    <?php
    require('header.php');
    require('../library/config.php');
    header('Content-Type: text/html;charset=UTF-8');
    ?>
    <title>Thêm chuyên mục</title>
    <!-- JavaScript -->
    <script>
        function addMember() {
        }
    </script>
    <!--Phần chính phía bên phải-->
<main role="main">
    <section class="panel important">
        <h2>Thêm thành viên </h2>
        <form name="addMember" id="addMember" method="POST" action="do_add_member.php">
            <div class="twothirds">
                <table class='table table-bordered'>
                    <tr>
                        <td>Tên đăng nhập</td> <td> <input type="text" name="username"/></td>
                    </tr>
                    <tr>
                        <td>Mật khẩu</td> <td> <input type="password" name="password"/></td>
                    </tr>
                    <tr>
                        <td>Họ tên</td> <td> <input type="text" name="full_name"/></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td> <input type="text" name="email"/></td>
                    </tr>
                    <tr>
                        <td>Tình trạng</td> <td> <select name="level">;
                                <option value='1'>Khóa</option>';
                                <option selected="selected" value='0'>Không khóa</option>';
                            </select></td>
                    </tr>
                    <tr>
                        <td>Link Avatar</td> <td> <input type="text" name="avatar_url"/></td>
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
                <input type="submit" class="button3" width="50" class="btn btn-default" value="Thêm"/>
            </div>
            </div>
        </form>
    </section>
</main>
<footer role="contentinfo">Trang rao vặt - SE28</footer>

</body>
<!-- Out Body -->
</html>