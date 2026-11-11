<?php
include_once "inc/functions.php";

if (empty($_SESSION["user"]["id"])) {
    header("Location: " . get_url(""));
    exit;
}

$user_id = $_SESSION["user"]["id"];

$sql = "SELECT posts.*, users.name, users.login, users.avatar FROM `likes` INNER JOIN `posts` ON likes.post_id = posts.id INNER JOIN `users` ON posts.user_id = users.id WHERE likes.user_id = ? ORDER BY posts.date DESC";

$posts = db_query($sql, [$user_id])->fetchAll(PDO::FETCH_ASSOC);
$title = "Мои понравившиеся твиты";
include_once "inc/header.php";
include_once "inc/posts.php"; 
include_once "inc/footer.php";
?>р