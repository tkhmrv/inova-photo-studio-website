<?php
require_once 'db_connection.php';
require_once 'functions.php';

session_start();

// Получаем информацию о текущем пользователе
$user = getCurrentUser();

// Закрываем соединение
// mysqli_close($conn);
?>

<body 
    data-user-logged-in="<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>" 
    data-user-photo="<?php echo isset($user['photo']) ? 'images/users/' . htmlspecialchars($user['photo']) : ''; ?>">
	
<div class="site-mobile-menu site-navbar-target">
	<div class="site-mobile-menu-header">
		<div class="site-mobile-menu-close">
			<span class="icofont-close js-menu-toggle"></span>
		</div>
	</div>
	<div class="site-mobile-menu-body"></div>
</div>

<nav class="site-nav">
	<div class="container">
		<div class="site-navigation">
			<a href="index.php" class="logo m-0 float-start">Inova<span class="text-primary">.</span> </a>

			<ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-start">
				<li><a href="services.php">Услуги</a></li>
				<li class="has-children">
					<a href="projects.php">Проекты</a>
					<ul class="dropdown" style="min-width: 11vw;">
						<li><a href="project-nike.php">Nike</a></li>
						<li><a href="project-acne.php">Acne Studios</a></li>
						<li><a href="project-koronskaya.php">Анастасия Коронская</a></li>
						<li><a href="project-teo.php">Тео Крафорд</a></li>
						<li><a href="project-rds.php">RDS GP</a></li>
						<li><a href="project-surf.php">Серфинг на Камчатке</a></li>
					</ul>
				</li>
				<li class="has-children">
					<a>Новости</a>
					<ul class="dropdown" style="min-width: 11vw;">
						<li><a href="universal-post.php?slug=street-photography">Уличная фотосъемка</a></li>
						<li><a href="universal-post.php?slug=grant-won">Грант</a></li>
						<li><a href="universal-post.php?slug=film-photography">Пленочная фотография</a></li>
					</ul>
				</li>
				<li><a href="about.php">О нас</a></li>
				<li><a href="contacts.php">Контакты</a></li>
			</ul>

			<a href="#" class="burger ml-auto float-end site-menu-toggle light js-menu-toggle d-inline-block d-lg-none"
				data-toggle="collapse" data-target="#main-navbar">
				<span></span>
			</a>

			<ul class="site-menu float-end d-none d-lg-inline-block" style="margin-top: 0.2vh;">
				<?php if (isset($_SESSION['user_id'])): ?>
					<li class="cta-button">
						<a href="account.php" style="padding: 0px;">
							<img src="images/users/<?php echo htmlspecialchars($user['photo']); ?>"
								alt="Аватар пользователя" class="rounded-circle"
								style="width: 50px; height: 50px; object-fit: cover;"
								data-bs-toggle="tooltip" data-bs-placement="bottom" title="Личный кабинет">
						</a>
					</li>
				<?php else: ?>
					<!-- <ul class="site-menu float-end d-none d-lg-inline-block ps-2"> -->
					<li class="cta-button">
							<a href="signin.php">Войти</a>
						</li>
						
						<li class="cta-button ps-2">
							<a href="signup.php">Зарегистрироваться</a>
						</li>
					<!-- </ul> -->
					<!-- <ul class="site-menu float-end d-none d-lg-inline-block"> -->
						
					<!-- </ul> -->
				<?php endif; ?>
			</ul>

		</div>
	</div>
</nav>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
