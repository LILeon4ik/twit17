<?php
include_once "inc/functions.php";

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id == false || $id <= 0) {
        header("Location: " . get_url(""));
        exit;
    }
    $posts = get_posts($id);
} else {
    $posts = get_posts();
}
if (!empty($_SESSION["user_auth"]) && !empty($_SESSION["user_info"]["login"])) {
    $title = $_SESSION["user_info"]["login"] . " - Главная страница";
} else {
    $title = "Главная страница";
}
include_once "inc/header.php";
include_once "inc/tweet_form.php";
include_once "inc/posts.php";
include_once "inc/footer.php";
