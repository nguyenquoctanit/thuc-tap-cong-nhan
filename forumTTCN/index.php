<?php 
	include('inc/header.php');
?>
<!-- ##### Hero Area Start ##### -->
    <section class="hero--area section-padding-80">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="tab-content">
                        <?php
                        if (isset($_SESSION['session_level']) && $_SESSION['session_level'] < LEVEL_MEMBER) {
                            // là quản lí hiển thị tất cả bài viết
                            $where_clause_hide_unverified_posts = " posts.username = users.username";
                        } else { // ẩn hết bài chưa kiểm duyệt nếu là thành viên, ngoại trừ chủ nhân bài viết
                            $include_my_posts = (isset($_SESSION['session_username']) ? ("or posts.username = '" . $_SESSION['session_username']) . "'" : "");
                            $where_clause_hide_unverified_posts = " posts.username = users.username and (posts.is_verified = 1 $include_my_posts )";
                        }
                        $row_top_one;
                        $select_top_posts = 'select post_id,counter, post_title,topic_id,full_name,picture, is_verified
                        from posts, users
                        where ' . $where_clause_hide_unverified_posts . ' 
                        order by posts.created_time DESC
                        limit 0 , 1';
                        $record_top_news = mysqli_query($connection,$select_top_posts);
                        if($record_top_news){
                            while($row_top = mysqli_fetch_assoc($record_top_news)){
                            $row_top_one = $row_top['post_id'];    
                            $highlighted_item = "";
                            if ($row_top['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }
                        ?>
                        <div class="tab-pane fade show active" id="post-<?php echo $row_top['post_id']; ?>" role="tabpanel" aria-labelledby="post-<?php echo $row_top['post_id']; ?>-tab">
                            <!-- Single Feature Post -->
                            <div class="single-feature-post video-post bg-img" style="background-image: url(upload_images/<?php echo $row_top['picture'];?>);">
                                <!-- Play Button -->
<!--                                 <a href="video-post.html" class="btn play-btn"><i class="fa fa-play" aria-hidden="true"></i></a> -->

                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="cat.php?id=<?php echo $row_top['topic_id'];?>" class="post-cata"><?php echo  get_name_category($connection,$row_top['topic_id']); ?></a>
                                    <a href="detail.php?post_id=<?php echo $row_top['post_id'];?>" <?php echo $highlighted_item; ?> class="post-title"><?php echo $row_top['post_title']; ?></a>
                                    <div class="post-meta d-flex">
                                        <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row_top['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_top['counter'];?></a>
                                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row_top['full_name']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        }      
                        ?>
                        <?php
                        $select_new_detail = 'select post_id,counter, post_title, full_name,topic_id,picture, is_verified
                        from posts, users
                        where ' . $where_clause_hide_unverified_posts.'
                        order by posts.created_time DESC
                        limit 1 , ' . MAX_NEW_ITEMS;
                                //echo $select_new_posts;
                        $result_new_detail = mysqli_query($connection,$select_new_detail);
                        if ($result_new_detail) {
                            while ($arr = mysqli_fetch_assoc($result_new_detail)) {
                            $highlighted_item = "";
                            if ($arr['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }            
                        ?>
                        <div class="tab-pane fade" id="post-<?php echo $arr['post_id']; ?>" role="tabpanel" aria-labelledby="post-<?php echo $arr['post_id']; ?>-tab">
                            <!-- Single Feature Post -->
                            <div class="single-feature-post video-post bg-img" style="background-image: url(upload_images/<?php echo $arr['picture'];?>);">
                                <!-- Play Button -->
                                <!-- <a href="video-post.html" class="btn play-btn"><i class="fa fa-play" aria-hidden="true"></i></a> -->

                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="cat.php?id=<?php echo $arr['topic_id'];?>" class="post-cata"><?php echo  get_name_category($connection,$arr['topic_id']); ?></a>
                                    <a href="detail.php?post_id=<?php echo $arr['post_id'];?>" <?php echo $highlighted_item; ?> class="post-title"><?php echo $arr['post_title']; ?></a>
                                    <div class="post-meta d-flex">
                                        <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $arr['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $arr['counter'];?></a>
                                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $arr['full_name']?></a>
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

                <div class="col-12 col-md-5 col-lg-4">
                    <ul class="nav vizew-nav-tab" role="tablist">
                        <?php
                        $select_new_posts = 'select post_id,counter, post_title,topic_id, full_name,picture, is_verified
                        from posts, users
                        where ' . $where_clause_hide_unverified_posts . ' 
                        order by posts.created_time DESC
                        limit 0 , ' . MAX_NEW_ITEMS;
                                //echo $select_new_posts;
                        $result_new_posts = mysqli_query($connection,$select_new_posts);
                        if ($result_new_posts) {
                            while ($row = mysqli_fetch_assoc($result_new_posts)) {
                            $highlighted_item = "";
                            if ($row['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }            
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" id="post-<?php echo $row['post_id']; ?>-tab" data-toggle="pill" href="#post-<?php echo $row['post_id']; ?>" role="tab" aria-controls="post-<?php echo $row['post_id']; ?>" aria-selected="true">
                                <!-- Single Blog Post -->
                                <div class="single-blog-post style-2 d-flex align-items-center">
                                    <div class="post-thumbnail" id="slide_tag_img">
                                        <img src="upload_images/<?php echo $row['picture'];?>" alt="">
                                    </div>
                                    <div class="post-content">
                                        <h6 class="post-title" <?php echo $highlighted_item; ?> ><?php echo $row['post_title'];?></h6>
                                        <div class="post-meta d-flex justify-content-between">
                                            <span><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row['post_id']); ?></span>
                                            <span><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row['counter'];?></span>
                                            <span><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row['full_name']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Trending Posts Area Start ##### -->
    <section class="trending-posts-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h4>Sách hay</h4>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Single Blog Post -->
                <?php
                $select_popular = 'select post_id,counter,post_title,video,time_video,topic_id, full_name,picture, is_verified
                from posts, users
                where ' . $where_clause_hide_unverified_posts . ' 
                order by posts.counter DESC
                limit 0 ,3';
                        //echo $select_new_posts;
                $result_popular = mysqli_query($connection,$select_popular);
                if ($result_popular) {
                    while ($row = mysqli_fetch_assoc($result_popular)) {
                            $highlighted_item = "";
                            if ($row['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }            
                ?>
                <div class="col-12 col-md-4">
                    <div class="single-post-area mb-80">
                        <!-- Post Thumbnail -->
                        <div class="post-thumbnail index_post">
                            <img src="upload_images/<?php echo $row['picture']; ?>" alt="">
                            <?php if($row['time_video']!=""){?>
                            <span class="video-duration"><?php echo $row['time_video']; ?></span>
                            <?php } ?>
                        </div>

                        <!-- Post Content -->
                        <div class="post-content">
                            <a href="cat.php?id=<?php echo $row['topic_id'];?>" class="post-cata cata-sm cata-success"><?php echo  get_name_category($connection,$row['topic_id']); ?></a>
                            <?php if($row['video']==""){ ?>
                            <a href="detail.php?post_id=<?php echo $row['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row['post_title']; ?></a>
                            <?php }else{ ?>
                            <a href="video_post.php?post_id=<?php echo $row['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row['post_title']; ?></a>
                            <?php } ?>    
                            <div class="post-meta d-flex">
                                <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row['post_id']); ?></a>
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row['counter'];?></a>
                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row['full_name']?></a>
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
    <!-- ##### Trending Posts Area End ##### -->

    <!-- ##### Vizew Post Area Start ##### -->
    <section class="vizew-post-area mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="all-posts-area">
                        <div class="row">
                            <?php
                            $sql_cat_rand = "select topic_id,topic_title from topics where parent_topic_id is not null order by rand() limit 0,4";
                            $record_cat_rand = mysqli_query($connection,$sql_cat_rand);
                            if($record_cat_rand){
                                while($row_cat_rand = mysqli_fetch_assoc($record_cat_rand)){
                            ?>        
                            <div class="col-12 col-lg-6">
                                <!-- Section Heading -->
                                <div class="section-heading style-2">
                                    <h4><?php echo $row_cat_rand['topic_title']; ?></h4>
                                    <div class="line"></div>
                                </div>

                                <!-- Sports Video Slides -->
                                <div class="sport-video-slides owl-carousel mb-50">
                                <?php 
                                $select_by_topic = 'select post_id,counter,video,time_video, post_title,picture, full_name, is_verified
                                from posts, users
                                where ' . $where_clause_hide_unverified_posts . ' and topic_id = ' . $row_cat_rand['topic_id']. '
                                order by posts.created_time DESC
                                limit 0,2';
                                //echo $select_posts;
                                $result_by_topic = mysqli_query($connection,$select_by_topic);
                                if($result_by_topic){
                                while ($row_by_topic = mysqli_fetch_assoc($result_by_topic)) {
                                    $highlighted_item = "";
                                    if ($row_by_topic['is_verified'] == FALSE) {
                                    $highlighted_item = "style='color:red;'";}
                                ?>
                                    <!-- Single Blog Post -->
                                    <div class="single-post-area">
                                        <!-- Post Thumbnail -->
                                        <div class="post-thumbnail index_post">
                                            <img src="upload_images/<?php echo $row_by_topic['picture']; ?>" alt="">
                                          <!-- Video Duration -->
                                        <?php if($row_by_topic['time_video']!=""){?>
                                        <span class="video-duration"><?php echo $row_by_topic['time_video']; ?></span>
                                        <?php } ?>
                                        </div>
                                        <!-- Post Content -->
                                        <div class="post-content">
                                            <a href="cat.php?id=<?php echo $row_cat_rand['topic_id'];?>" class="post-cata cata-sm cata-success"><?php echo $row_cat_rand['topic_title']; ?></a>
                                            <?php if($row_by_topic['video']==""){ ?>
                                            <a href="detail.php?post_id=<?php echo $row_by_topic['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row_by_topic['post_title']; ?></a>
                                            <?php }else{ ?>
                                            <a href="video_post.php?post_id=<?php echo $row_by_topic['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?>><?php echo $row_by_topic['post_title']; ?></a>
                                            <?php } ?>    
                                            <div class="post-meta d-flex">
                                            <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row_by_topic['post_id']); ?></a>
                                            <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_by_topic['counter'];?></a>
                                            <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row_by_topic['full_name']?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }   
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php 
                                    }
                                }
                            ?>    
                        </div>
                        <!-- Section Heading -->
                        <div class="section-heading style-2">
                            <h4>Review Sách</h4>
                            <div class="line"></div>
                        </div>
                            
                        <!-- Featured Post Slides -->
                        <div class="featured-post-slides owl-carousel mb-30">
                            <!-- Single Feature Post -->
                        <?php    
                        $select_top_video = 'select post_id,counter, post_title,topic_id,video,full_name,picture,time_video,is_verified
                        from posts, users
                        where ' . $where_clause_hide_unverified_posts . ' and video !=""  
                        order by posts.created_time DESC
                        limit 0 , 3';
                        $record_top_video = mysqli_query($connection,$select_top_video);
                        if($record_top_video){
                            while($row_top = mysqli_fetch_assoc($record_top_video)){
                            $top_video_id = $row_top['post_id'];    
                            $highlighted_item = "";
                            if ($row_top['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }
                        ?>
                            <div class="single-feature-post video-post bg-img" style="background-image: url(upload_images/<?php echo $row_top['picture']; ?>);">
                                <!-- Play Button -->
                                <a href="video_post.php?post_id=<?php echo $row_top['post_id'];?>" class="btn play-btn"><i class="fa fa-play" aria-hidden="true"></i></a>

                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="cat.php?id=<?php echo $row_top['topic_id'];?>" class="post-cata"><?php echo get_name_category($connection,$row_top['topic_id']); ?></a>
                                    <a href="video_post.php?post_id=<?php echo $row_top['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?> ><?php echo $row_top['post_title']; ?></a>
                                    <div class="post-meta d-flex">
                                       <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $top_video_id); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_top['counter'];?></a>
                                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row_top['full_name']?></a>
                                    </div>
                                </div>

                                <!-- Video Duration -->
                                <span class="video-duration"><?php echo $row_top['time_video']; ?></span>
                            </div>
                            <?php
                                }
                            }
                            ?>
                            <!-- abc -->
                        </div>
                        <!-- Single Post Area -->
                        <?php    
                        $select_then_video = 'select post_id,counter,posts.created_time,post_title,topic_id,full_name,video,picture,time_video,is_verified
                        from posts, users
                        where ' . $where_clause_hide_unverified_posts.' and video !=""
                        order by posts.created_time DESC
                        limit 3 , 3';
                        $record_then_video = mysqli_query($connection,$select_then_video);
                        if($record_then_video){
                            while($row_then = mysqli_fetch_assoc($record_then_video)){ 
                            $highlighted_item = "";
                            if ($row_then['is_verified'] == FALSE){
                                $highlighted_item = "style='color:red;'";
                            }
                        ?>
                        <div class="single-post-area mb-30">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6">
                                    <!-- Post Thumbnail -->
                                    <div class="post-thumbnail index_post">
                                        <img src="upload_images/<?php echo $row_then['picture'];?>" alt="">

                                        <!-- Video Duration -->
                                        <span class="video-duration"><?php echo $row_then['time_video']; ?></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <!-- Post Content -->
                                    <div class="post-content mt-0">
                                        <a href="cat.php?id=<?php echo $row_then['topic_id'];?>" class="post-cata cata-sm cata-success"><?php echo get_name_category($connection,$row_then['topic_id']); ?></a>
                                        <a href="video_post.php?post_id=<?php echo $row_then['post_id'];?>" class="post-title mb-2" <?php echo $highlighted_item; ?> ><?php echo $row_then['post_title']; ?></a>
                                        <div class="post-meta d-flex align-items-center mb-2">
                                            <a href="#" class="post-author"><?php echo $row_then['full_name']; ?></a>
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <a href="#" class="post-date"><?php echo $row_then['created_time']; ?></a>
                                        </div>
                                        <div class="post-meta d-flex">
                                       <a href=""><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection,$row_then['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_then['counter'];?></a>
                                        </div>
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
<?php
    include('inc/rightbar.php');
?>
            </div>
        </div>
    </section>
    <!-- ##### Vizew Psot Area End ##### -->
<?php
	include('inc/footer.php');
?>