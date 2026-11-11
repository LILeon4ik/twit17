<?php
include_once("functions.php");

$post_id = $_GET['id'];
$user_id = $_SESSION["user"]["id"];
    db_query("DELETE FROM `likes` WHERE `user_id` = ? AND `post_id` = ?", [$user_id, $post_id]);
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;