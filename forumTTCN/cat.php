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
                        $page = 1;
                        if (isset($_GET['id'])) {
                            $topic_id = (int) $_GET['id'];
                                if (isset($_GET['page'])) {
                                    $page = (int) $_GET['page'];
                                }
                                if ($topic_id <= 0 || $page <= 0) {
                                    header("location: index.php"); // Quay về trang chủ nếu không nhập đúng số
                                }
                        }else {
                            header("location: index.php");
                        }
                        $user_level = LEVEL_VISITOR;
                        if (isset($_SESSION['session_level']) && $_SESSION['session_level'] < LEVEL_MEMBER){
                        $where_clause_hide_unverified_posts = " posts.username = users.username ";
                        } else { // ẩn hết bài chưa kiểm duyệt nếu là thành viên, ngoại trừ chủ nhân bài viết
                        $include_my_posts = (isset($_SESSION['session_username']) ? ("or posts.username = '" . $_SESSION['session_username']) . "'" : "");
                        $where_clause_hide_unverified_posts = " posts.username = users.username and (posts.is_verified = 1 $include_my_posts )";
                        }
                        $start_point = MAX_ITEMS_PER_PAGE * ($page - 1);
                        $select_posts = 'select post_id,counter,video,post_title, full_name,picture, is_verified
                                from posts, users
                                where ' . $where_clause_hide_unverified_posts . ' and topic_id = ' . $topic_id . '
                                order by posts.created_time DESC
                                limit ' . $start_point . ' , ' . MAX_ITEMS_PER_PAGE;
                        //echo $select_posts;
                        $result_new_posts = mysqli_query($connection,$select_posts);
                        if($result_new_posts){
                            ?>
                    <!-- Archive Catagory & View Options -->
                    <div class="archive-catagory-view mb-50 d-flex align-items-center justify-content-between">
                        <!-- Catagory -->
                        <div class="archive-catagory">
                            <h4><i class="fa fa-trophy" aria-hidden="true"></i>&nbsp;<?php echo get_name_category($connection,$topic_id);?></h4>
                        </div>
                        <!-- View Options -->
                        <div class="view-options">
                        <?php if (isset($_SESSION['session_level'])){ ?>                
                       <a href="insert_post.php?insert_id=<?php echo $topic_id; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a> <?php }else{?>
                        <a href="javascript:void(0)" onclick="alert('Bạn phải là thành viên mới được quyền đăng bài viết!!!');"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                        <?php } ?>       
                        </div>
                    </div>
                    <div class="row">
                        <?php 
                            while ($row = mysqli_fetch_assoc($result_new_posts)) {
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
                                    <a href="#" class="post-cata cata-sm cata-success"><?php echo get_name_category($connection, $topic_id); ?></a>
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
                    <!-- Pagination -->
                    <nav class="mt-50">
                        <ul class="pagination justify-content-center">
                            <?php
                            $number_of_posts = get_self_posts_number($connection, $topic_id);
                            $max_page = ceil($number_of_posts / MAX_ITEMS_PER_PAGE);
                            if ($page > 1) {   
                            ?>
                            <li class="page-item"><a class="page-link" href="cat.php?id=<?php echo $topic_id;?>&page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a></li>
                             <?php 
                             }
                             for ($page_item = 1; $page_item <= $max_page; $page_item++) {
                                $active_class = "";
                                $current_mark = "";
                                $href_link = 'cat.php?id=' . $topic_id . '&page=' . $page_item;
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
                                if ($page < $max_page && $number_of_posts > MAX_ITEMS_PER_PAGE) {
                                    ?>
                                    <li class="page-item"><a class="page-link" href="cat.php?id=<?php echo $topic_id;?>&page=<?php echo ($page+1); ?>"><i class="fa fa-angle-right"></i></a></li>
                               <?php 
                                }    
                             ?>   
                        </ul>
                    </nav>
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