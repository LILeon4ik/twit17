<?php
include_once "functions.php";

$user_id = $_SESSION['user']['id'];
$text = $_GET['text'];
$image = $_GET['image'];

if (empty($image)) {
    $image = null;
}
db_query("INSERT INTO `posts`(`user_id`, `text`, `image`) VALUES (?,?,?)", [$user_id, $text, $image]);
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();