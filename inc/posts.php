<section class="wrapper">
    <?php if (isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])) {
        $posts_liked_user = get_posts_liked_user($_SESSION['user']['id']);
    }
    ?>
    <ul class="tweet-list">
        <?php
        foreach ($posts as $post) {
        ?>
            <li>
                <article class="tweet">
                    <div class="row">
                        <img class="avatar" src="<?= $post['avatar'] ?>" alt="Аватар">
                        <div class="tweet__wrapper">
                            <header class="tweet__header">
                                <h3 class="tweet-author"><?= $post['name'] ?>
                                    <a href="<?= get_url("user_posts.php?id=" . $post["user_id"]) ?>" class="tweet-author__add tweet-author__nickname">@<?= $post['login'] ?></a>
                                    <time class="tweet-author__add tweet__date"><?= date('d.m.Y в H:i', strtotime($post['date'])) ?></time>
                                </h3>
                                <?php if (isset($_SESSION["user"]["id"]) && $_SESSION["user"]["id"] == $post['user_id']): ?>
                                    <form method="GET" action="<?= get_url("inc/delete_tweet.php") ?>">
                                        <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                        <button class="tweet__delete-button chest-icon"></button>
                                    </form>
                                <?php endif; ?>
                            </header>
                            <div class="tweet-post">
                                <p class="tweet-post__text"><?= $post['text'] ?></p>
                                <?php if (!empty($post['image'])): ?>
                                    <figure class="tweet-post__image">
                                        <img src="<?= $post['image'] ?>" alt="">
                                    </figure>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <footer>
                        <?php if (isset($_SESSION["user"]["login"]) && !empty($_SESSION["user"]["login"])): ?>

                            <?php if (in_array($post['id'], $posts_liked_user)): ?>
                                <form method="GET" action="<?= get_url("inc/delete_like.php") ?>">
                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                    <button type="submit" class="tweet__like tweet__like_active"><?= likes($post['id'] ?? 0) ?></button>
                                </form>
                            <?php else: ?>
                                <form method="GET" action="<?= get_url("inc/insert_like.php") ?>">
                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                    <button type="submit" class="tweet__like"><?= likes($post['id'] ?? 0) ?></button>
                                </form>
                            <?php endif; ?>

                        <?php else: ?>
                            <button class="tweet__like"><?= likes($post['id'] ?? 0) ?></button>
                        <?php endif; ?>
                    </footer>
                </article>
            </li>
        <?php
        }
        ?>
    </ul>
</section>