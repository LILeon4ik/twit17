<?php
include_once("functions.php");
$user_info = auth_user($_POST);
if (! $user_info) {
    header("Location: " . get_url("index.php"));
}
//echo "<pre>";
//var_dump($_POST);
//echo "</pre>";
//die();