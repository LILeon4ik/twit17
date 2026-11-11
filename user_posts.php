<?php
include_once "inc/functions.php";

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        header("Location: " . get_url(""));
        exit;
    }
    $posts = get_posts($id);
    // 23.10.2026 исправление Warning если у пользователя нет постов
    if (!empty($posts)) {
        $title = "Посты @" . $posts[0]["login"];
    } else {
        $user = db_query("SELECT login FROM `users` WHERE `id` = ?", [$id])->fetch(); // Если такой пользователь есть в базе, в переменную $user запишется массив.
        if ($user) {
            $title = "Посты @" . $user["login"];
        } else {
            $posts = get_posts();
            $title = "Посты всех пользователей";
        }
    }
}
include_once "inc/header.php";
include_once "inc/tweet_form.php";
include_once "inc/posts.php";
include_once "inc/footer.php";
