<?php
require_once 'db_connection.php';
require_once 'functions.php';

// Получаем информацию о текущем пользователе
$user = getCurrentUser();
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="author" content="Tikhomirov Semyon">
	<link rel="shortcut icon" href="images/logo.png">

	<meta name="description"
		content="Одна из лучших и перспективных студий профессиональной фотографии и видеосъемки в Санкт-Петербурге. Приглашаем моделей, фотографов и видеографов в нашу команду." />
	<meta name="keywords" content="фотостудия, фотосалон, фотография, видеография" />

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap"
		rel="stylesheet">

	<link rel="stylesheet" href="fonts/icomoon/style.css">
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="css/tiny-slider.css">
	<link rel="stylesheet" href="css/aos.css">
	<link rel="stylesheet" href="css/glightbox.min.css">
	<link rel="stylesheet" href="css/style.css">

	<title>Inova &mdash; студия профессиональной фотографии и видеосъемки</title>
</head>

<?php include 'templates/header.php'; ?>

<div class="hero-2 overlay" style="background-image: url('images/hero3.jpg');">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-5 mx-auto ">
				<h1 class="mb-5 text-center"><span>Контакты</span></h1>


				<div class="intro-desc text-left">
					<div class="line"></div>
					<p>Свяжитесь с нами для получения дополнительной информации или записи на съемку. Мы всегда рады
						помочь вам и готовы обсудить ваши идеи и пожелания в удобное время.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="section sec-4" style="padding-bottom: 1rem;">
	<div class="container">
		<div class="row border-bottom pb-5 justify-content-between">
			<div class="col-lg-4 align-self-center mb-5">
				<h2 class="heading mb-4">Мы всегда рады видеть вас</h2>
				<p><a href="tel:+79876543210">+7 (987) 654-32-10</a>
					<br>
					<a href="mailto:hello@inova.com">hello@inova.com</a>
					<br>
				<h3 class="h6 text-black">Городоград, ул. Гастелло, 38</h3>
				</p>
				<ul class="social-2 list-unstyled mb-5">
					<li><a href="#"><span class="icon-telegram"></span></a></li>
					<li><a href="#"><span class="icon-instagram"></span></a></li>
					<li><a href="#"><span class="icon-vk"></span></a></li>
				</ul>
			</div>

			<div class="col-lg-7">
				<iframe
					src="https://yandex.ru/map-widget/v1/?um=constructor%3A5e6855cf30e91953f15a86db069d7b5648f69809d89aa94f9a50e669e18f9d42&amp;source=constructor"
					allowfullscreen="true"></iframe>
			</div>
		</div>
	</div>
</div>

<div class="section sec-contact">
	<div class="container">
		<div class="row mb-5 justify-content-center text-center">
			<div class="col-lg-5">
				<h2 class="heading">Свяжитесь с нами</h2>
				<p class="text-black-50">Не нашли то, что искали? Вы можете связаться с нами напрямую или заполнить
					форму и рассказать о своем опыте. </p>
			</div>
		</div>
		<form action="service/send_feedback_form.php" method="post" class="row">

			<div class="col-md-6 col-lg-6">
				<div class="mb-3">
					<label for="name" class="ps-3 mb-2">Имя *</label>
					<input class="form-control" type="text" autocomplete="on" name="name" minlength="3" maxlength="100"
						required pattern="^[A-Za-zА-Яа-яЁё\s]*$" id="name" value="<?php if (isset($user['name']))
							echo htmlspecialchars($user['name']); ?>">
				</div>
			</div>

			<div class="col-md-6 col-lg-6">
				<div class="mb-3">
					<label for="email" class="ps-3 mb-2">Электронная почта *</label>
					<input class="form-control" type="email" autocomplete="on" name="email" id="email" required value="<?php if (isset($user['email']))
						echo htmlspecialchars($user['email']); ?>">
				</div>
			</div>

			<div class="col-md-6 col-lg-12">
				<div class="mb-3">
					<label for="subject" class="ps-3 mb-2">Тема *</label>
					<input type="text" class="form-control" id="subject" name="subject" minlength="3" maxlength="100"
						required pattern="^[A-Za-zА-Яа-яЁё\s]*$">
				</div>
			</div>

			<div class="col-md-12 col-lg-12">
				<div class="mb-3">
					<label for="message" class="ps-3 mb-2">Сообщение *</label>
					<textarea class="form-control" name="message" id="message" cols="30" rows="7" required
						maxlength="200" placeholder="Не более 200 символов"></textarea>
				</div>
			</div>

			<div class="col-md-12">
				<input type="submit" value="Отправить сообщение" class="btn btn-primary">
			</div>

		</form>
	</div>
</div>


<?php include 'templates/footer.php'; ?>

<!-- Preloader -->
<div id="overlayer"></div>
<div class="loader">
	<div class="spinner-border" role="status">
		<span class="visually-hidden">Loading...</span>
	</div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/aos.js"></script>
<script src="js/glightbox.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Проверяем, есть ли данные для toast
		const toastData = <?php echo json_encode($_SESSION['toast'] ?? null); ?>;
		if (toastData) {
			<?php unset($_SESSION['toast']); ?>

			// Находим элементы toast
			const toastElement = document.getElementById('toast');
			const toastMessage = document.getElementById('toastMessage');

			// Устанавливаем сообщение
			toastMessage.textContent = toastData.message;

			// Добавляем стиль в зависимости от типа сообщения
			if (toastData.type === 'error') {
				toastElement.classList.add('error');
			} else {
				toastElement.classList.remove('error');
			}

			// Показываем toast
			toastElement.classList.add('show');
			setTimeout(() => {
				toastElement.classList.remove('show');
			}, 50000); // Убираем через 5 секунд
		}
	});
</script>

<div class="toast-container">
	<div id="toast" class="toast">
		<div class="d-flex align-items-center">
			<div class="toast-body">
				<span id="toastMessage"></span>
			</div>
			<button type="button" class="btn-close" aria-label="Close"
				onclick="this.closest('.toast').classList.remove('show')">&times;</button>
		</div>
	</div>
</div>
</body>

</html>