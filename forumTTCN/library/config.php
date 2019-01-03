<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'diendan');
$connection = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$connection->set_charset("utf8");
define('LEVEL_VISITOR', 6);
define('LEVEL_MEMBER', 4);
define('LEVEL_MODERATOR', 2);
define('LEVEL_ADMIN', 0);

define('MAX_NEW_ITEMS', 7); // Số bài viết mới
define('MAX_ITEMS_PER_PAGE', 2); // Số items (post, reply) trên 1 trang.
?>