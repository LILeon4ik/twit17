<?php
include_once("functions.php");
$title = "Регистрация пользователя";
register_user($_POST);
header("Location: " . get_url("register.php"));
exit();
//echo "<pre>";
//var_dump($_POST);
//echo "</pre>";
//die();