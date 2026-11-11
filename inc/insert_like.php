<?php
include_once("functions.php");
$post_id = $_GET['id'];
$user_id = $_SESSION["user"]["id"];
db_query("INSERT INTO `likes` (`user_id`, `post_id`) VALUES (?, ?)", [$user_id, $post_id]);
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
