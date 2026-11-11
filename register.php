<?php
include_once "inc/functions.php";
if (isset($_SESSION["user_auth"]) && $_SESSION["user_auth"]) {
    $user_login = $_SESSION["user_info"]["login"];
} else {
    $user_login = "Регистрация";
}

$title = $user_login . " - " . " Регистрация";
include_once "inc/header.php";
include_once "inc/register_form.php";
include_once "inc/footer.php";
