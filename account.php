<?php
require_once 'db_connection.php';
require_once 'functions.php';

session_start();

// Проверяем, есть ли активная сессия
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

// Получаем информацию о текущем пользователе
$user = getCurrentUser();

// Закрываем соединение
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Tikhomirov Semyon">
    <link rel="shortcut icon" href="images/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/account.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Inova &mdash; Личный кабинет</title>
</head>

<body>

    <div class="container p-0 mb-3">
        <h1 class="h3">Личный кабинет</h1>
        <div class="row">
            <div class="col-md-5 col-xl-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Настройки профиля</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account"
                            role="tab">
                            Общая информация
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#password"
                            role="tab">
                            Пароль
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#delete-account"
                            role="tab">
                            Удалить аккаунт
                        </a>

                        <a class="list-group-item list-group-item-action " href="index.php" role="button">
                            Вернуться на сайт →
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-xl-8">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account" role="tabpanel">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions float-right">
                                    <div class="dropdown show">
                                        <a href="#" data-toggle="dropdown" data-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-horizontal align-middle">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item text-danger" href="exit.php">Выйти</a>
                                            <?php if ($user['role_id'] == 2): ?>
                                                <a class="dropdown-item" href="https://xn--80ahdri7a.site:9080/login/"
                                                    target="_blank">Hestia</a>
                                                <a class="dropdown-item" href="https://xn--80ahdri7a.site/phpmyadmin/"
                                                    target="_blank">phpMyAdmin</a>
                                                <a class="dropdown-item" href="https://github.com/tkhmrv/cw"
                                                    target="_blank">GitHub</a>
                                                <a class="dropdown-item" href="https://yclients.com/online/booking_forms/1195711"
                                                    target="_blank">YClients</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="card-title mb-0">Информация о пользователе</h5>
                            </div>
                            <div class="card-body">
                                <form action="service/update_user.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name">Имя</label>
                                                <input class="form-control" type="text" autocomplete="on" name="name"
                                                    minlength="3" maxlength="100" required
                                                    pattern="^[A-Za-zА-Яа-яЁё\s]*$" id="name" placeholder="Имя"
                                                    value="<?php echo htmlspecialchars($user['name']); ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Логин</label>
                                                <input class="form-control" type="text" autocomplete="on"
                                                    name="username" id="username" minlength="3" maxlength="20" required
                                                    pattern="^[\w]+$" placeholder="Логин"
                                                    value="<?php echo htmlspecialchars($user['username']); ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Электронная почта</label>
                                                <input class="form-control" type="email" autocomplete="on" name="email"
                                                    id="email" required placeholder="Электронная почта"
                                                    value="<?php echo htmlspecialchars($user['email']); ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="website">Веб-сайт</label>
                                                <input type="text" class="form-control" id="website" name="website"
                                                    placeholder="Веб-сайт"
                                                    value="<?php echo htmlspecialchars($user['website']); ?>">
                                            </div>
                                        </div>



                                        <div class="col-md-4 my-auto">
                                            <div class="text-center">
                                                <img alt="Аватар пользователя"
                                                    src="images/users/<?php echo htmlspecialchars($user['photo']); ?>"
                                                    class="rounded-circle img-responsive mt-2" width="128" height="128">
                                                <div class="mt-2">
                                                    <span class="btn btn-primary"
                                                        onclick="document.getElementById('customFile').click()">
                                                        <i class="fa fa-upload"></i>
                                                    </span>
                                                    <input type="file" name="photo" class="form-control" id="customFile"
                                                        style="display: none;" onchange="uploadPhoto(this)">
                                                </div>
                                                <small>JPG, JPEG, GIF или PNG. Максимальный размер 2Мб</small>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary">Сохранить
                                        изменения</button>

                                </form>


                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Пароль</h5>
                            </div>
                            <div class="card-body">
                                <form action="service/change_password.php" method="POST">
                                    <div class="form-group">
                                        <label for="currentPassword">Текущий пароль</label>
                                        <input type="password" class="form-control" id="currentPassword"
                                            name="currentPassword">
                                        <small><a href="#">Забыли пароль?</a></small>
                                    </div>

                                    <div class="form-group">
                                        <p class="text-muted font-size-sm">Пароль должен содержать не менее 8 символов,
                                            заглавную и строчную букву, цифру и специальный
                                            символ.</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Новый пароль
                                        </label>
                                        <input class="form-control" type="password" id="password" minlength="8"
                                            maxlength="40" required
                                            pattern="^(?=.*[A-Z])(?=.*[\d])(?=.*[a-z])(?=.*[\W])[a-zA-Z\d\W]{6,20}$"
                                            name="password"
                                            oninput="checkpass(document.getElementById('validate-password').value)">
                                    </div>

                                    <div class="form-group">
                                        <label for="validate-password">Подтвердите пароль</label>
                                        <input class="form-control" type="password" id="validate-password" minlength="8"
                                            maxlength="40" required
                                            pattern="^(?=.*[A-Z])(?=.*[\d])(?=.*[a-z])(?=.*[\W])[a-zA-Z\d\W]{6,20}$"
                                            name="validate-password" oninput="checkpass(this.value)">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Обновить пароль</button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="delete-account" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-danger">Удаление аккаунта</h5>
                            </div>
                            <div class="card-body">
                                <form action="service/delete_account.php" method="POST">
                                    <div class="form-group">
                                        <p class="text-muted font-size-sm">Будьте осторожны, это действие нельзя
                                            отменить.</p>
                                    </div>
                                    <button class="btn btn-danger" type="submit">Удалить навсегда</button>
                                </form>
                            </div>
                        </div>
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

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/upload-photo.js"></script>
    


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
                }, 5000); // Убираем через 5 секунд
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