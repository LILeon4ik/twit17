<?php if (isset($_SESSION["user"]["id"])): ?>
<section class="wrapper">
    <form class="tweet-form" method="get" action="inc/insert_tweet.php">
        <div class="tweet-form__wrapper">
            <img class="avatar" src="<?= $_SESSION['user']['avatar'] ?>" alt="Аватар">
            <textarea class="tweet-form__text" name="text" rows="4" placeholder="Что происходит?" required></textarea>
        </div>
        <div class="tweet-form__btns">
            <button class="tweet-img__btn" type="button"></button>
            <span id="image-span">path/to/image</span>
            <input type="hidden" id="image-path" name="image">
            <button class="tweet-form__btn" type="submit">Твитнуть</button>
        </div>
    </form>
</section>
<?php endif; ?>