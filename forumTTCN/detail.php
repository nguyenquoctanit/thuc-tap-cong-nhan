<?php 
    include('inc/header.php');
    $post_id;
    $page = 1;
    if (isset($_GET['post_id'])){
        $post_id = (int) $_GET['post_id'];
        if (isset($_GET['page'])) {
            $page = (int) $_GET['page'];
        }
        if ($post_id <= 0 || $page <= 0) {
            header("location: exit.php?result=Bạn nhập không đúng số trang hoặc id bài viết"); // Quay về trang chủ nếu không nhập đúng số
        }
    }else {
        header("location: index.php");
    }
    ?>
    <!-- ##### Breadcrumb Area Start ##### -->
    <div class="vizew-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->
    <!-- ##### Post Details Area Start ##### -->
    <section class="post-details-area mb-80">
        <div class="container">
            <?php
            //Lượt đọc
            $sqlCount = "UPDATE posts SET counter = (counter + 1) WHERE post_id = {$post_id}";
            $rsCount = mysqli_query($connection,$sqlCount);
            $select_post = "select posts.*, full_name,email, avatar_url from posts,users where post_id = $post_id and posts.username=users.username";
            $result_select_post = mysqli_query($connection,$select_post);
            if ($result_select_post) {
                if ($row_post = mysqli_fetch_array($result_select_post)) {
                $is_verified = $row_post['is_verified'];
                if (!$is_verified && !isset($_SESSION['session_username'])) { // chưa đăng nhập
                    header("location: exit.php?result=warning"); // nhảy
                }
                if (!$is_verified && isset($_SESSION['session_level']) && $_SESSION['session_level'] >= LEVEL_MEMBER){
                    if (isset($_SESSION['session_username']) && $_SESSION['session_username'] != $row_post['username']) {
                        header("location: exit.php?result=warning"); // nhảy
                    }
                }
                $verify_button = "";
                $remove_button = "";
                if (!$is_verified) {
                    $panel_type = "danger";
                    $verify_button = '<div class="col-xs-12 col-md-3" style="margin-top:20px;"><a href="pages/do_update.php?mod=verifying&post_id=' . $post_id . '"class="btn btn-success btn-block"></span> Chấp nhận</a></div><div class="col-xs-12 col-md-9" style="padding-top:20px;"><strong class="text text-danger">BÀI VIẾT CHƯA ĐƯỢC XÉT DUYỆT</strong>, các thành viên khác sẽ không thể nhìn thấy bài viết này</div>';
                }

            ?>
            <div class="row">
                <div class="col-12">
                    <div class="post-details-thumb mb-50" style="text-align:center">
                        <img src="upload_images/<?php echo $row_post['picture'] ?>" alt="">
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Post Details Content Area -->
                <div class="col-12 col-lg-8 col-xl-7">
                    <div class="post-details-content">
                        <!-- Blog Content -->
                        <div class="blog-content">

                            <!-- Post Content -->
                            <div class="post-content mt-0">
                                <a href="#" class="post-cata cata-sm cata-danger"><?php echo get_name_category($connection, $row_post['topic_id']); ?></a>
                                <a href="#" class="post-title mb-2"><?php echo $row_post['post_title'];?></a>

                                <div class="d-flex justify-content-between mb-30">
                                    <div class="post-meta d-flex align-items-center">
                                        <a href="#" class="post-author">By <?php echo $row_post['full_name'];?></a>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <a href="#" class="post-date"><?php echo $row_post['created_time']; ?></a>
                                    </div>
                                    <div class="post-meta d-flex">
                                         <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row_post['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_post['counter'];?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="post_content">
                            <?php
                            if ($page == 1) { //IF-BLOCK
                            // Chỉ trang 1 mới hiển thị nội dung POST
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?php echo $row_post['post_content'];?>
                                </div>
                            <?php  
                            // Nếu là chủ nhân bài viết hoặc là mod/admin thì hiện nút xóa / sửa
                            if ($row_post['username'] == (isset($_SESSION["session_username"]) ? $_SESSION["session_username"] : '') || (isset($_SESSION["session_level"]) ? $_SESSION["session_level"] : LEVEL_VISITOR) < LEVEL_MEMBER){
                                echo '
                                    <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <a href="update_post.php?post_id=' . $post_id. '"class="btn btn-success btn-block"><span class="glyphicon glyphicon-edit"></span> Sửa</a>
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <a class="btn btn-warning btn-block" href="pages/do_delete.php?mod=post&post_id=' . $post_id . '"
                                                    onClick="return confirm(\'Chắc chắn?\')"><span class="glyphicon glyphicon-remove"></span> Xóa
                                                    </a>
                                                </div>
                                                ' . ($_SESSION["session_level"] < LEVEL_MEMBER ? $verify_button : "") . '
                                            </div>
                                    </div>
                                    ';
                                }
                            }
                            ?>
                            </div>
                            </div>
                            <!-- Related Post Area -->
                            <div class="related-post-area mt-5">
                                <!-- Section Title -->
                                <div class="section-heading style-2">
                                    <h4>Related Post</h4>
                                    <div class="line"></div>
                                </div>

                                <div class="row">
                        <?php 
                        if (isset($_SESSION['session_level']) && $_SESSION['session_level'] < LEVEL_MEMBER){
                        $where_clause_hide_unverified_posts = " posts.username = users.username ";
                        } else { // ẩn hết bài chưa kiểm duyệt nếu là thành viên, ngoại trừ chủ nhân bài viết
                        $include_my_posts = (isset($_SESSION['session_username']) ? ("or posts.username = '" . $_SESSION['session_username']) . "'" : "");
                        $where_clause_hide_unverified_posts = " posts.username = users.username and (posts.is_verified = 1 $include_my_posts )";
                        }
                        $select_relate = 'select topic_id,post_id,counter,video,post_title,time_video, full_name,picture,is_verified
                                from posts, users
                                where ' . $where_clause_hide_unverified_posts . ' and post_id !=' . $post_id . ' and topic_id ='.$row_post['topic_id'].'
                                order by posts.created_time DESC
                                limit 2';
                        //echo $select_posts;
                        $result_relate = mysqli_query($connection,$select_relate);
                        if($result_relate){
                            while ($row_relate = mysqli_fetch_assoc($result_relate)){
                            $highlighted_item = "";
                            if ($row_relate['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }
                        ?>
                                    <!-- Single Blog Post -->
                                    <div class="col-12 col-md-6">
                                        <div class="single-post-area mb-50">
                                            <!-- Post Thumbnail -->
                                            <div class="post-thumbnail" id="relate_img">
                                                <img src="upload_images/<?php echo $row_relate['picture']; ?>" alt="">
                                                <!-- Video Duration -->
                                                <?php if($row_relate['time_video']!=""){?>
                                                <span class="video-duration"><?php echo $row_relate['time_video']; ?></span>
                                                <?php } ?>
                                            </div>

                                            <!-- Post Content -->
                                            <div class="post-content">
                                                <a href="cat.php?id=<?php echo $row_relate['topic_id'];?>" class="post-cata cata-sm cata-success">&nbsp;<?php echo get_name_category($connection,$row_relate['topic_id']);?></a>
                                                 <?php if($row_relate['video']==""){ ?>
                                                <a href="detail.php?post_id=<?php echo $row_relate['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row_relate['post_title']; ?></a>
                                                <?php }else{ ?>
                                                <a href="video_post.php?post_id=<?php echo $row_relate['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row_relate['post_title']; ?></a>
                                                <?php } ?>    
                                                <div class="post-meta d-flex">
                                                    <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row_relate['post_id']); ?></a>
                                                    <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_relate['counter'];?></a>
                                                    <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;<?php echo $row_relate['full_name']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                }
                                    ?>            
                                </div>
                            </div>

                            <!-- Comment Area Start -->
                            <div class="comment_area clearfix mb-50">
                                <?php 
                                // Các bình luận ===================================================
                                $replies_per_page = MAX_ITEMS_PER_PAGE;
                                $start_point = $replies_per_page * ($page - 1);
                                // Lấy các bình luận của trang hiện tại
                                $select_replies = "select replies.*, users.full_name, users.avatar_url from replies,users where replies.username = users.username and post_id = $post_id order by created_time asc limit $start_point, $replies_per_page";
                                //echo $select_replies;

                                ?>
                                <!-- Section Title -->
                                <div class="section-heading style-2">
                                    <h4>Bình luận</h4>
                                    <div class="line"></div>
                                </div>

                                <ul>
                                <?php 
                                $result_select_replies = mysqli_query($connection,$select_replies);
                                if ($result_select_replies) {
                                    while ($row_replies = mysqli_fetch_array($result_select_replies)) {
                                        $action_buttons = ""; //mặc định không có
                                        if (isset($_SESSION['session_username'])): // IF-BLOCK
                                            //Nếu là mod/admin hoặc chủ nhân bình luận (không bị khóa nick) thì sẽ có 2 nút
                                            if ($_SESSION['session_level'] < LEVEL_MEMBER || ($row_replies['username'] == $_SESSION['session_username'] && $_SESSION['session_is_blocked'] == FALSE)) {
                                                $action_buttons = '
                                                    <span>
                                                        <a href="pages/do_delete.php?mod=reply&reply_id=' . $row_replies['reply_id'] . '&post_id=' . $post_id . '" class="btn btn-warning btn-sm" onClick="return confirm(\'Chắc chắn?\')">Xóa</a>
                                                    </span>
                                                ';
                                            }
                                        endif; // END IF-BLOCK
                                ?>    

                                    <!-- Single Comment Area -->
                                    <li class="single_comment_area">
                                        <!-- Comment Content -->
                                        <div class="comment-content d-flex">
                                            <!-- Comment Author -->
                                            <div class="comment-author">
                                                <img src="upload_images/user_images/<?php echo $row_replies['avatar_url']; ?>" alt="author">
                                            </div>
                                            <!-- Comment Meta -->
                                            <div class="comment-meta">
                                                <a href="#" class="comment-date"><?php echo $row_replies['created_time']; ?></a>
                                                <h6><?php echo $row_replies['full_name'];?></h6>
                                                <p><?php echo $row_replies['content']?></p>
                                            </div>
                                            <?php echo $action_buttons;?>
                                        </div>
                                    </li>
                                    <?php
                                        }
                                     }   
                                    ?>
                                </ul>                                  
                                <nav class="mt-50">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        $number_of_replies = get_replies_number($connection, $post_id);
                                        $max_page = ceil($number_of_replies / MAX_ITEMS_PER_PAGE);
                                        if ($page > 1){   
                                        ?>
                                        <li class="page-item"><a class="page-link" href="detail.php?post_id=<?php echo $post_id;?>&page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a></li>
                                         <?php 
                                         }
                                         for ($page_item = 1; $page_item <= $max_page; $page_item++){
                                            $active_class = "";
                                            $current_mark = "";
                                            $href_link = 'detail.php?post_id=' . $post_id . '&page=' . $page_item;
                                            if ($page == $page_item) { // đang ở trang hiện tại thì thiết kế để nó in đậm lên
                                                $active_class ="active";
                                                $current_mark = '<span class="sr-only">(current)</span>';
                                                $href_link = "#";
                                            }
                                            // echo '<li' . $active_class . '><a href="' . $href_link . '">' . $page_item . ' ' . $current_mark . '</a></li>';
                                            ?>
                                            <li class="page-item <?php echo $active_class; ?>"><a class="page-link" href="<?php echo $href_link; ?>"><?php echo $page_item; ?>&nbsp;<?php echo $current_mark; ?></a></li>
                                        <?php 
                                            }
                                            // Nếu không phải trang cuối, và có nhiều hơn 1 trang thì có nút qua trang
                                            if ($page < $max_page && $number_of_replies > MAX_ITEMS_PER_PAGE){
                                                ?>
                                                <li class="page-item"><a class="page-link" href="detail.php?post_id=<?php echo $post_id;?>&page=<?php echo ($page+1); ?>"><i class="fa fa-angle-right"></i></a></li>
                                           <?php 
                                            }    
                                         ?>   
                                    </ul>
                                </nav>
                            </div>
                            <?php
                            // Khung bình luận ===================================================
                            // Chỉ dành cho thành viên đã đăng nhập (và không bị blocked), dành cho bài viết đã được duyệt
                            if (isset($_SESSION['session_username']) && $_SESSION['session_is_blocked'] == FALSE && $is_verified) {

                            ?>

                            <!-- Post A Comment Area -->
                            <div class="post-a-comment-area">
                                <!-- Reply Form -->
                                <div class="contact-form-area">
                                    <form action="pages/do_insert.php" method="post">
                                        <input type="hidden" name="mod" value="reply">
                                        <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                        <input type="hidden" name="username" value="<?= (isset($_SESSION['session_username']) ? $_SESSION['session_username'] : '') ?>">
                                        <div class="row">
<!--                                             <div class="col-12 col-lg-6">
                                                <input type="text" class="form-control" id="name" placeholder="Your Name*">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <input type="email" class="form-control" id="email" placeholder="Your Email*">
                                            </div> -->
                                            <div class="col-12">
                                                <textarea class="form-control" id="message" placeholder="Message*" name="content_reply"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn vizew-btn mt-30" type="submit">Submit Comment</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                            }else{
                                echo "Bạn không có quyền bình luận bài viết này!";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Widget -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="sidebar-area">

                        <!-- ***** Single Widget ***** -->
                        <div class="single-widget share-post-widget mb-50">
                            <p>Share This Post</p>
                            <a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
                            <a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a>
                            <a href="#" class="google"><i class="fa fa-google" aria-hidden="true"></i> Google+</a>
                        </div>

                        <!-- ***** Single Widget ***** -->
                        <div class="single-widget p-0 author-widget">
                            <div class="p-4">
                                <img class="author-avatar" src="upload_images/user_images/<?php echo $row_post['avatar_url']; ?>" alt="">
                                <a href="#" class="author-name"><?php echo $row_post['full_name'];?></a>
                                <div class="author-social-info">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                                <p><?php echo $row_post['email'];?></p>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
                    }
                }    
                ?>
            </div>
        </div>
    </section>
    <!-- ##### Post Details Area End ##### -->
<?php
    include('inc/footer.php');
?>