<?php
include_once "inc/functions.php";

$sort = $_GET['sort'];

$_SESSION['sort'] = $sort;

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
