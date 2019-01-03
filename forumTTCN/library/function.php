<?php
include_once("config.php");
// Hàm đếm số bài viết trong 1 chuyên mục (bao gồm cả chuyên mục con)
// Số lượng trả về số lượng dựa vào quyền hạn của người dùng
//Hàm trả về tên danh mục của bài viết
function get_name_category($connection, $topic_id){
    $sql = "SELECT topic_title FROM topics WHERE topic_id = $topic_id";
    $result = mysqli_query($connection,$sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['topic_title'];
    }
}
function get_posts_number($connection, $topic_id) {
    $user_level = LEVEL_VISITOR; // khách
    if (isset($_SESSION['session_level'])) {
        $user_level = $_SESSION['session_level'];
    }
    if ($user_level < LEVEL_MEMBER) { // là quản lí
        $hide_unverified_posts = "";
    } else { // là thành viên hoặc khách
        $hide_unverified_posts = " posts.is_verified = 1 and ";
    }
    $num = 0;
    $sql = "select count(post_id) from posts where $hide_unverified_posts topic_id = $topic_id";
    $result = mysqli_query($connection,$sql); //truy vấn cơ sở dữ liệu
    if ($result) {
        if ($row = mysqli_fetch_array($result)) {
            $num = $row[0];
        }
        // Đếm số bài viết của chuyên mục con nếu có
        $sql_2 = "select topic_id from topics where parent_topic_id = $topic_id";
        $result_2 = mysqli_query($connection,$sql_2);
        if ($result_2) {
            while ($row_2 = mysqli_fetch_array($result_2)) {
                $num += get_posts_number($connection, $row_2[0]); // tự đệ quy cộng thêm
            }
        }
    }
    return $num;
}
// Hàm đếm số phản hồi trong 1 bài viết
function get_replies_number($connection, $post_id) {
    $sql = "select count(reply_id) from replies where post_id = $post_id";
    $result = mysqli_query($connection,$sql);
    if ($result) {
        if ($row = mysqli_fetch_array($result)) {
            return $row[0];
        }
    }
    return 0;
}

// Hàm đếm số bài viết của 1 chuyên mục (không đếm của chuyên mục con)
function get_self_posts_number($connection, $topic_id) {
    $user_level = LEVEL_VISITOR; // khách
    if (isset($_SESSION['session_level'])) {
        $user_level = $_SESSION['session_level'];
    }
    if ($user_level < LEVEL_MEMBER) { // là quản lí
        $hide_unverified_posts = "";
    } else { // là thành viên hoặc khách
        $hide_unverified_posts = " posts.is_verified = 1 and ";
    }
    $num = 0;
    $sql = "select count(post_id) from posts where $hide_unverified_posts topic_id = $topic_id";
    $result = mysqli_query($connection,$sql);
    if ($result) {
        if ($row = mysqli_fetch_array($result)) {
            $num = $row[0];
        }
    }
    return $num;
}

// lấy đường dẫn breadcrumbs của 1 chuyên mục nào đó
function get_topic_breadcrumbs($connection, $topic_id) {
    $breadcrumbs = '';
    $sql = "select topic_id, topic_title, parent_topic_id from topics where topic_id = $topic_id";
    $result = mysqli_query($connection,$sql);
    $parent_topic_id = " parent_topic_id is null ";
    if ($result) {
        if ($row = mysqli_fetch_array($result)) {
            $breadcrumbs .= '<li><a href="view_topic.php?topic_id=' . $row[0] . '">' . $row[1] . '</a></li>';
            if ($row[1] <> NULL) {
                $parent_topic_id = " parent_topic_id = " . $row[2];
            }
        }
        // Chèn thêm chuyên mục cha ở phía trước
        $sql_2 = "select parent_topic_id from topics where $parent_topic_id";
        $result_2 = mysqli_query($connection,$sql_2);
        if ($result_2) {
            if ($row_2 = mysqli_fetch_array($result_2)) {
                $temp = get_topic_breadcrumbs($connection, $row_2[0]); // tự đệ quy lấy thêm
                $breadcrumbs = $temp . $breadcrumbs; // gắn vào trước
            }
        }
    }
    return $breadcrumbs;
}

// Hàm lấy danh sách các biểu tượng và trả về dạng HTML <option>
function get_icon_names($connection) {
    $html = '';
    $sql = "select icon_name from icons";
    $result = mysqli_query($connection,$sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $name = $row[0];
            $html .= "<option value=\"$name\">glyphicon-$name</option> ";
        }
    }
    return $html;
}

?>