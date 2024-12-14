<?php
// Подключаем файл подключения к базе данных
require_once 'db_connection.php';
require_once 'functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inova &mdash; вход в аккаунт</title>

    <meta name="author" content="Tikhomirov Semyon">
    <link rel="shortcut icon" href="images/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="css/auth/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <div class="site-wrap d-md-flex align-items-stretch">
        <div class="bg-img" style="background-image: url('images/signin.jpg')"></div>
        <div class="form-wrap">
            <div class="form-inner">
                <h1 class="title">Добро пожаловать!</h1>
                <p class="caption mb-4">Пожалуйста, введите логин и пароль для входа.</p>

                <?php
                // Инициализация переменных для отображения ошибок и сохранения введенных данных
                $username = '';
                $error = '';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Чтение данных формы
                    $username = filter_input(
                        INPUT_POST,
                        'username',
                        FILTER_VALIDATE_REGEXP,
                        array('options' => array('regexp' => '/^[\w]+$/'))
                    );
                    $password = $_POST['password'];

                    // Подготовленный запрос для проверки логина
                    try {
                        $query_user = "SELECT id, username, password FROM user WHERE username = ?";
                        $stmt_user = mysqli_prepare($conn, $query_user);
                        mysqli_stmt_bind_param($stmt_user, 's', $username);
                        mysqli_stmt_execute($stmt_user);
                        mysqli_stmt_store_result($stmt_user);
                        mysqli_stmt_bind_result($stmt_user, $user_id, $user_username, $hashed_password);
                        mysqli_stmt_fetch($stmt_user);

                        if (mysqli_stmt_num_rows($stmt_user) > 0) {
                            // Проверка пароля
                            if (password_verify($password, $hashed_password)) {
                                //При успешной авторизации в базу данных помещаем token и устанавливаем cookie
                                $token = bin2hex(random_bytes(15));
                                $query = "UPDATE user SET token='{$token}' WHERE id='{$user_id}';";

                                $row = mysqli_query($conn, $query);

                                // Сохраняем данные в сессии
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['token'] = $token;
                                if (isset($_POST['trust-this-browser'])) {
                                    // Устанавливаем параметры сессии для продления срока жизни на 60 дней
                                    ini_set('session.gc_maxlifetime', 5184000);
                                    ini_set('session.cookie_lifetime', 5184000);
                                }
                                // Если логин и пароль верны, перенаправляем на страницу профиля
                                header("Location: account.php");
                                exit();
                            } else {
                                $error = "Неверный пароль.";
                            }
                        } else {
                            $error = "Пользователь не найден.";
                        }

                        // Закрытие соединения
                        mysqli_stmt_close($stmt_user);
                        mysqli_close($conn);
                    } catch (Exception $e) {
                        $error = "Возникла ошибка при авторизации и проверке пароля (попробуйте позже): ";
                        handl_error($error, $e->getMessage());
                        exit();
                    }
                }
                ?>

                <?php if ($error): ?>
                    <p class="caption mb-4" style="color: red;" id="error-message"><?php echo htmlspecialchars($error); ?>
                    </p>
                    <script>
                        $(document).ready(function () {
                            setTimeout(function () {
                                $('#error-message').hide();
                            }, 5000);
                        });
                    </script>
                <?php endif; ?>


                <form method="post" action="signin.php" class="pt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Логин">
                        <label for="username">Логин</label>
                    </div>

                    <div class="form-floating">
                        <span class="password-show-toggle js-password-show-toggle"><span class="uil"></span></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                        <label for="password">Пароль</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="trust-this-browser"
                                name="trust-this-browser">
                            <label for="trust-this-browser" class="form-check-label">Доверять этому браузеру</label>
                        </div>
                        <div><a href="#">Забыли пароль?</a></div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </div>

                    <div class="mb-2">Нет аккаунта? <a href="signup.php">Зарегистрироваться</a></div>

                    <!-- <div class="social-account-wrap">
                        <h4 class="mb-4"><span>or continue with</span></h4>
                        <ul class="list-unstyled social-account d-flex justify-content-between">
                            <li><a href="#"><img src="images/icon-google.svg" alt="Google logo"></a></li>
                            <li><a href="#"><img src="images/icon-facebook.svg" alt="Facebook logo"></a></li>
                            <li><a href="#"><img src="images/icon-apple.svg" alt="Apple logo"></a></li>
                            <li><a href="#"><img src="images/icon-twitter.svg" alt="Twitter logo"></a></li>
                        </ul>
                    </div> -->

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="js/auth.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
</body>

</html>