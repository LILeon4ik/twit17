	</main>
	</div>
	<div class="modal overlay">
		<div class="container modal__body" id="login-modal">
			<div class="modal-close">
				<button class="modal-close__btn chest-icon"></button>
			</div>
			<section class="wrapper">
				<h2 class="tweet-form__title">Введите логин и пароль</h2>
				<?php if (isset($_SESSION['auth_error'])): ?>
					<div class="tweet-form__error"><?= $_SESSION['auth_error'] ?></div>
				<?php endif; ?>
				<div class="tweet-form__subtitle">Если у вас нет логина, пройдите <a href="<?= get_url("register.php") ?>">регистрацию</a></div>
				<form class="tweet-form" action="inc/auth_user.php" method="post">
					<div class="tweet-form__wrapper_inputs">
						<input name="login" type="text" class="tweet-form__input" placeholder="Логин" required value="trampampam">
						<input name="pass" type="password" class="tweet-form__input" placeholder="Пароль" required value="trampampam">
					</div>
					<div class="tweet-form__btns_center">
						<button class="tweet-form__btn_center" type="submit">Войти</button>
					</div>
				</form>
			</section>
		</div>
	</div>
	<script src="<?= get_url("js/scripts.js") ?>"></script>
	<?php
	if (isset($_SESSION['auth_error'])) {
		echo "<script>openModal()</script>";
		unset($_SESSION['auth_error']);
	}
	?>

	</body>

	</html>