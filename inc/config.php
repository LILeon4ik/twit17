<?php

define("SITE_NAME", "Twitter");
define("HOST", "http://" . $_SERVER["HTTP_HOST"]);  // для get_url()
define("DB_HOST", "127.0.0.1");                     // для PDO
define("DB_NAME", "tw17");
define("DB_USER", "root");
define("DB_PASS", "");

session_start();
