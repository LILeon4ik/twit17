<?php
include_once "config.php";

function debug($var, $stop = false)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if ($stop)
        die;
}
function get_url($page = "")
{
    return HOST . "/" . $page;
}

function get_page_title($title = "")
{
    if (empty($title)) {
        return SITE_NAME;
    } else {
        return SITE_NAME . " - " . $title;
    }
}
function db()
{
    try {
        $dbh = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        return $dbh;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

function db_query($sql, $params = [])
{
    if (empty($sql))
        return false;

    $dbh = db();
    if ($dbh === null) {
        return false;
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

//$rows = db_query("SELECT * FROM posts");
//if ($rows !== false) {
//  echo "<pre>";
//foreach ($rows as $row) {
//  print $row['user_id'] . "\t";
//print $row['text']   . "\t";
//print $row['image']  . "\n";
// }
//echo "</pre>";
//}

function get_posts($user_id = 0)
{
    $sort = ($_SESSION['sort'] ?? 'desc') == 'asc' ? 'ASC' : 'DESC';

    if ($user_id > 0) {
        $sql = "SELECT posts.*, users.name, users.login, users.avatar FROM `posts` INNER JOIN `users` ON users.id = posts.user_id WHERE posts.user_id = ? ORDER BY posts.date $sort";
        return db_query($sql, [$user_id])->fetchAll(PDO::FETCH_ASSOC);
    }

    $sql = "SELECT posts.id, user_id, text, image, date, login, name, avatar FROM `posts` INNER JOIN `users` ON posts.user_id = users.id ORDER BY posts.date $sort";
    return db_query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function add_user($login, $pass)
{
    $login = trim($login);
    $password = password_hash($pass, PASSWORD_DEFAULT);
    return db_query("INSERT INTO `users` (`id`, `login`, `pass`, `name`) VALUES (NULL, '$login', '$password', 'Qwe');");
}


function get_user_info($login)
{
    return db_query("SELECT * FROM `users` WHERE `login` = '$login'")->fetch(PDO::FETCH_ASSOC);
}


function register_user($register_data)
{
    $name = trim($register_data['name'] ?? '');
    $login = trim($register_data['login'] ?? '');
    $pass1 = $register_data['pass1'] ?? '';
    $pass2 = $register_data['pass2'] ?? '';

    if (empty($name) || empty($login) || empty($pass1) || empty($pass2)) {
        $_SESSION['error'] = "Заполните все поля.";
        return false;
    }

    if ($pass1 !== $pass2) {
        $_SESSION['error'] = "Пароли не совпадают.";
        return false;
    }

    $db_user = get_user_info($login);
    if (!empty($db_user)) {
        $_SESSION['error'] = "Пользователь с логином «{$login}» уже существует.";
        return false;
    }

    $hash = password_hash($pass1, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users` (`login`, `pass`, `name`) VALUES (?, ?, ?)";
    $result = db_query($sql, [$login, $hash, $name]);

    if ($result) {
        $_SESSION['success'] = "Пользователь «{$login}» успешно зарегистрирован!";
        $_SESSION['user_registred'] = true;
        $_SESSION['user_auth'] = true;
        $_SESSION['user_info'] = ["login" => $login, "name" => $name, "avatar" => "images/no_avatar.png"];
        return true;
    }

    $_SESSION['error'] = "Ошибка регистрации. Попробуйте позже.";
    return false;
}


function auth_user($auth_data)
{
    $login = trim($auth_data['login'] ?? '');
    $pass = $auth_data['pass'] ?? '';

    if (empty($login) || empty($pass)) {
        $_SESSION['auth_error'] = "Заполните все поля.";
        header("Location: " . get_url());
        exit;
    }
    $db_user = get_user_info($login);
    if (!empty($db_user)) {
        if (password_verify($pass, $db_user["pass"])) {
            header("Location: " . get_url("user_posts.php?id=") . $db_user['id']);
            $_SESSION['user'] = array("login" => $login, "id" => $db_user['id'], "avatar" => $db_user['avatar']);
            exit;
        } else {
            $_SESSION['auth_error'] = 'Неверный логин или пароль';
            header("Location: " . get_url());
            exit;
        }
    } else {
        $_SESSION['auth_error'] = 'Пользователь с таким логином @' . $login . ' не зарегистрирован.';
        return false;
    }
}
function likes($post_id)
{
    $result = db_query("SELECT COUNT(*) as count FROM `likes` WHERE post_id = ?", [$post_id])->fetch();
    return $result['count'];
}
function get_posts_liked_user($user_id)
{
    return db_query("SELECT post_id FROM `likes` WHERE user_id = ?", [$user_id])
        ->fetchAll(PDO::FETCH_COLUMN);
}
