<!doctype html>
<html lang="ru">

<head>
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

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="../css/tiny-slider.css">
    <link rel="stylesheet" href="../css/aos.css">
    <link rel="stylesheet" href="../css/glightbox.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <title>Inova &mdash; студия профессиональной фотографии и видеосъемки</title>
</head>

<body></body>

<div class="hero-2 overlay" style="background-image: url('../images/hero4.jpg');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto">
                <!-- <h1 class="mb-5"><span>Ой, что-то пошло</span> <span class="d-block">не по плану :(</span> <span
                        class="d-block">Такой страницы не существует</span></h1> -->

                <?php
                $status = $_GET['status'] ?? 'unknown';

                switch ($status) {
                    case 'success':
                        echo '
        <h1 class="mb-5">
            <span>Email успешно подтвержден!</span>
            <span class="d-block">Теперь вы можете</span>
            <span class="d-block">войти в личный кабинет</span>
        </h1>';
                        break;

                    case 'already_verified':
                        echo '
        <h1 class="mb-5">
            <span>Email уже подтвержден.</span>
            <span class="d-block">Вы ранее подтвердили</span>
            <span class="d-block">свой адрес электронной почты</span>
        </h1>';
                        break;

                    case 'invalid_token':
                        echo '
        <h1 class="mb-5">
            <span>Ой, что-то пошло</span>
            <span class="d-block">не по плану :(</span>
            <span class="d-block">Неверный токен</span>
        </h1>';
                        break;

                    case 'no_token':
                        echo '
        <h1 class="mb-5">
            <span>Ой, что-то пошло</span>
            <span class="d-block">не по плану :(</span>
            <span class="d-block">Токен отсутствует</span>
        </h1>';
                        break;

                    default:
                        echo '
        <h1 class="mb-5">
            <span>Ой, что-то пошло</span>
            <span class="d-block">не по плану :(</span>
            <span class="d-block">Неизвестная ошибка</span>
        </h1>';
                }
                ?>

                <div class="play-vid">
                    <a href="../index.php" class="btn btn-outline-light btn-sm w-100">
                        На главную
                    </a>
                </div>
                <div class="play-vid mt-3">
                    <a href="../account.php" class="btn btn-outline-light btn-sm w-100">
                        В личный кабинет
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preloader -->
<div id="overlayer"></div>
<div class="loader">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Загрузка...</span>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/aos.js"></script>
<script src="../js/glightbox.min.js"></script>
<script src="../js/navbar.js"></script>
<script src="../js/counter.js"></script>
<script src="../js/custom.js"></script>
</body>

</html>