# Работа с паролями в PHP: `password_hash` и `password_verify`

## 1. `password_hash` — создаёт хеш пароля

### Что делает
Создаёт **необратимый хеш** пароля через сильный алгоритм (по умолчанию bcrypt). Из хеша нельзя получить исходный пароль обратно — можно только проверить, подходит ли пароль к хешу (это делает `password_verify`).

### Синтаксис
```php
password_hash(string $password, string|int|null $algo, array $options = []): string
```

- `$password` — пароль, который ввёл пользователь.
- `$algo` — алгоритм хеширования. Обычно `PASSWORD_DEFAULT` (bcrypt).
- `$options` — дополнительные настройки (например, `cost`). Обычно не нужны.

### Важные моменты
- Соль генерируется автоматически и включается в хеш. Хранить её отдельно не нужно.
- Длина хеша может меняться при смене алгоритма, поэтому в БД поле делаем `VARCHAR(255)`.
- Хеш всегда разный, даже для одного и того же пароля — из-за случайной соли.

### Пример
```php
<?php
$password = "my_secure_password";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
// Вывод: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
?>
```

### Использование при регистрации
```php
<?php
$login = $_POST['login'];
$password = $_POST['password'];

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (login, pass) VALUES (?, ?)";
db_query($sql, [$login, $hash]);
?>
```

---

## 2. `password_verify` — проверяет пароль по хешу

### Что делает
Сравнивает обычный пароль с хешем из базы. Возвращает `true`, если пароль подходит, и `false`, если нет.

### Синтаксис
```php
password_verify(string $password, string $hash): bool
```

- `$password` — пароль, который ввёл пользователь.
- `$hash` — хеш из базы (тот, что вернул `password_hash`).

### Важные моменты
- Не нужно доставать соль или алгоритм отдельно — вся информация уже внутри хеша.
- Функция безопасна для атак по времени (timing attacks).
- Работает с хешами, созданными и `password_hash()`, и `crypt()`.

### Пример
```php
<?php
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

if (password_verify('my_secure_password', $hash)) {
    echo 'Пароль правильный!';
} else {
    echo 'Неверный пароль.';
}
?>
```

### Использование при авторизации
```php
<?php
$login = $_POST['login'];
$password = $_POST['password'];

$sql = "SELECT id, login, pass FROM users WHERE login = ?";
$user = db_query($sql, [$login])->fetch();

if ($user && password_verify($password, $user['pass'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['login'] = $user['login'];
    header("Location: " . get_url(""));
    exit;
} else {
    echo "Неверный логин или пароль";
}
?>
```

---

## Сводка

| | `password_hash` | `password_verify` |
|---|---|---|
| Назначение | Создать хеш пароля | Проверить пароль по хешу |
| Возвращает | Строку (хеш) | `true` / `false` |
| Где используется | При регистрации | При входе |
| Соль | Генерируется автоматически | Не нужна — уже внутри хеша |
| Хеш в БД | `VARCHAR(255)` | — |

---

**Главное правило:** никогда не храни пароли в открытом виде и не используй `md5()` или `sha1()` — только `password_hash()`.