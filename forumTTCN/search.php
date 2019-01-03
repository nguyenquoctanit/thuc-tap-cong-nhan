<?php 
    include('inc/header.php');
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

    <!-- ##### Archive Grid Posts Area Start ##### -->
    <div class="vizew-grid-posts-area mb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                     <?php
                        $topic_id;
                        $top_search;
                        $page = 1;
                        if (isset($_GET['page'])) {
                            $page = (int) $_GET['page'];
                        }
                        $top_search = htmlspecialchars($_POST['top-search']);
                        $user_level = LEVEL_VISITOR;
                        if (isset($_SESSION['session_level']) && $_SESSION['session_level'] < LEVEL_MEMBER) {
                        $where_clause_hide_unverified_posts = " posts.username = users.username ";
                        } else { // ẩn hết bài chưa kiểm duyệt nếu là thành viên, ngoại trừ chủ nhân bài viết
                        $include_my_posts = (isset($_SESSION['session_username']) ? ("or posts.username = '" . $_SESSION['session_username']) . "'" : "");
                        $where_clause_hide_unverified_posts = " posts.username = users.username and (posts.is_verified = 1 $include_my_posts )";
                        }
                        // $start_point = MAX_ITEMS_PER_PAGE * ($page - 1);
                        $select_posts = 'select topic_id, post_id,counter,video,post_title, icon_name, full_name,picture, is_verified
                                from posts, users
                                where ' . $where_clause_hide_unverified_posts . 'and post_title LIKE "%'.$top_search.'%" 
                                order by posts.created_time DESC';
                        $result_new_posts = mysqli_query($connection,$select_posts);
                        // $record_count = mysqli_num_rows($result_new_posts);
                        // echo $record_count;
                        // $record_count;
                        if($result_new_posts){
                            ?>
                    <!-- Archive Catagory & View Options -->
                    <div class="archive-catagory-view mb-50 d-flex align-items-center justify-content-between">
                        <!-- Catagory -->
                        <div class="archive-catagory">
                            <h4><i class="fa fa-trophy" aria-hidden="true"></i>&nbsp;Kết quả tìm kiếm được cho từ khóa : <span style="color:red"><?php echo $top_search;?><span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <?php 
                            while ($row = mysqli_fetch_assoc($result_new_posts)) {
                            $topic_id = $row['topic_id'];    
                            $highlighted_item = "";
                            if ($row['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }
                        ?>    
                        <!-- Single Blog Post -->
                        <div class="col-12 col-md-6">
                            <div class="single-post-area mb-50">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail" id="cat_post">
                                    <img src="upload_images/<?php echo $row['picture']; ?>" alt="<?php echo $row['post_id'];?>" width="350px" height="200px">
                                </div>

                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="cat.php?id=<?php echo $topic_id;?>" class="post-cata cata-sm cata-success"><?php echo get_name_category($connection, $topic_id); ?></a>
                                    <?php if($row['video']==""){ ?>
                                    <a href="detail.php?post_id=<?php echo $row['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row['post_title']; ?></a>
                                    <?php }else{ ?>
                                    <a href="video_post.php?post_id=<?php echo $row['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row['post_title']; ?></a>
                                    <?php } ?>    
                                    <div class="post-meta d-flex">
                                        <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row['counter'];?></a>
                                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row['full_name']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <?php                                                 
                        }
                    ?>
                </div>
        <?php
    include('inc/rightbar.php');
?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Archive Grid Posts Area End ##### -->
<?php
    include('inc/footer.php');
?>