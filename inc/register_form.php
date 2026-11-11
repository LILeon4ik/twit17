<section class="wrapper">
    <h2 class="tweet-form__title">Регистрация</h2>

    <?php if (isset($_SESSION["error"]) && !empty($_SESSION["error"])): ?>
        <div class="tweet-form__error"><?= $_SESSION["error"] ?></div>
        <?php unset($_SESSION["error"]); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION["success"]) && !empty($_SESSION["success"])): ?>
        <div class="tweet-form__success"><?= $_SESSION["success"] ?></div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>
    <form class="tweet-form" method="post" action="inc/register_user.php">
        <div class="tweet-form__wrapper_inputs">
            <input type="text" class="tweet-form__input" placeholder="Имя" required name="name">
            <input type="text" class="tweet-form__input" placeholder="Логин" required name="login">
            <input type="password" class="tweet-form__input" placeholder="Пароль" required name="pass1">
            <input type="password" class="tweet-form__input" placeholder="Пароль повторно" required name="pass2">
        </div>
        <div class="tweet-form__btns_center">
            <button class="tweet-form__btn_center" type="submit">Зарегистрироваться</button>
        </div>
    </form>
</section>