<?php
include_once("functions.php");
$post_id = $_GET['id'];
$user_id = $_SESSION["user"]["id"];
db_query("DELETE FROM posts WHERE `id` = $post_id AND `user_id` = $user_id");
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;