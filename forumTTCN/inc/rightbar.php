        <div class="col-12 col-md-5 col-lg-4">
                    <div class="sidebar-area">

                        <!-- ***** Single Widget ***** -->
                        <div class="single-widget followers-widget mb-50">
                            <a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i><span class="counter">198</span><span>Fan</span></a>
                            <a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i><span class="counter">220</span><span>Followers</span></a>
                            <a href="#" class="google"><i class="fa fa-google" aria-hidden="true"></i><span class="counter">140</span><span>Subscribe</span></a>
                        </div>

                        <!-- ***** Single Widget ***** -->
                        <div class="single-widget latest-video-widget mb-50">
                            <!-- Section Heading -->
                            <div class="section-heading style-2 mb-30">
                                <h4>Bài đăng mới nhất</h4>
                                <div class="line"></div>
                            </div>
                        <?php    
                        $select_latest = 'select post_id,counter, post_title, icon_name,topic_id,full_name,picture, is_verified
                        from posts, users
                        where ' . $where_clause_hide_unverified_posts . ' 
                        order by posts.created_time DESC
                        limit 0 , 1';
                        $record_latest = mysqli_query($connection,$select_latest);
                        if($record_latest){
                        while($row_latest = mysqli_fetch_assoc($record_latest)){
                        $highlighted_item = "";
                        if ($row_latest['is_verified'] == FALSE) {
                            $highlighted_item = "style='color:red;'";
                        }
                        ?>
                            <!-- Single Blog Post -->
                            <div class="single-post-area mb-30">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail" id="rightbar_img">
                                    <img src="upload_images/<?php echo $row_latest['picture'];?>" alt="">
                                </div>

                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="cat.php?id=<?php echo $row_latest['topic_id'];?>" class="post-cata cata-sm cata-success"><?php echo  get_name_category($connection,$row_latest['topic_id']); ?></a>
                                    <a href="detail.php?post_id=<?php echo $row_latest['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?> ><?php echo $row_latest['post_title']; ?></a>
                                    <div class="post-meta d-flex">
                                         <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row_latest['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_latest['counter'];?></a>
                                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row_latest['full_name']; ?></a>
                                    </div>
                            </div>
                            </div>
                            <?php
                                }
                            } 
                            $select_latest_then = 'select post_id,counter, post_title, icon_name,topic_id,full_name,picture, is_verified
                            from posts, users
                            where ' . $where_clause_hide_unverified_posts . ' 
                            order by posts.created_time DESC
                            limit 1 , 3';
                            $record_latest_then = mysqli_query($connection,$select_latest_then);
                            if($record_latest_then){
                            while($row_latest_then = mysqli_fetch_assoc($record_latest_then)){
                            $highlighted_item = "";
                            if ($row_latest_then['is_verified'] == FALSE) {
                                $highlighted_item = "style='color:red;'";
                            }
                            ?>
                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex">
                                <div class="post-thumbnail" id="rightbar_img_small">
                                    <img src="upload_images/<?php echo $row_latest_then['picture'];?>" alt="">
                                </div>
                                <div class="post-content">
                                    <a href="detail.php?post_id=<?php echo $row_latest_then['post_id'];?>" class="post-title" <?php echo $highlighted_item; ?> ><?php echo $row_latest_then['post_title'];?></a>
                                    <div class="post-meta d-flex justify-content-between">
                                         <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<?php echo get_replies_number($connection, $row_latest_then['post_id']); ?></a>
                                        <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?php echo $row_latest_then['counter'];?></a>
                                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $row_latest_then['full_name']; ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            }  
                            ?>
                        </div>

                        <!-- ***** Single Widget ***** -->
                        <div class="single-widget add-widget mb-50">
                            <a href="#"><img src="img/bg-img/add.png" alt=""></a>
                        </div>