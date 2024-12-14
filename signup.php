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
    <title>Inova &mdash; регистрация в фотостудии</title>

    <meta name="author" content="Tikhomirov Semyon">
    <link rel="shortcut icon" href="images/logo.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="css/auth/style.css">
</head>

<body>

    <div class="site-wrap d-md-flex align-items-stretch">
        <div class="bg-img" style="background-image: url('images/signup.jpg')"></div>
        <div class="form-wrap">
            <div class="form-inner">
                <h1 class="title">Регистрация</h1>
                <p class="caption mb-4">Создайте аккаунт за несколько секунд
                <p>

                    <?php
                    // Инициализация переменных для формы
                    $name = '';
                    $username = '';
                    $email = '';
                    $error = '';
                    $success = '';

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Получение данных из формы и Фильтрация данных
                        $name = filter_input(INPUT_POST, 'name', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[A-Za-zА-Яа-яЁё\s]*$/u')));
                        $username = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w]+$/')));
                        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                        $password = $_POST['password'];

                        // Проверяем, что поля не пустые и корректны
                        if (!$name || !$username || !$email || !$password) {
                            die("Некорректные данные. Проверьте заполнение формы.");
                        }

                        // Хеширование пароля
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        try {
                            // Проверка, существует ли уже пользователь с таким логином или email
                            $query_check_user = "SELECT * FROM users WHERE username = ? OR email = ?";
                            $stmt_check = mysqli_prepare($conn, $query_check_user);
                            mysqli_stmt_bind_param($stmt_check, 'ss', $username, $email);
                            mysqli_stmt_execute($stmt_check);
                            mysqli_stmt_store_result($stmt_check);

                            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                                $error = "Пользователь с таким логином или email уже существует.";
                            } else {
                                $token = bin2hex(random_bytes(32)); //сгенерируем токен
                    
                                // Запись в базу данных
                                $query_add_user = "INSERT INTO users(
                            name, 
                            username, 
                            password, 
                            email, 
                            token) 
                            VALUES(?, ?, ?, ?, ?)";

                                $stmt_user = mysqli_prepare($conn, $query_add_user);
                                mysqli_stmt_bind_param(
                                    $stmt_user,
                                    'sssss',
                                    $name,
                                    $username,
                                    $password_hash,
                                    $email,
                                    $token
                                );

                                $msqq = mysqli_stmt_execute($stmt_user);

                                if ($msqq) {
                                    $user_id = strval(mysqli_insert_id($conn));

                                    $_SESSION['user_id'] = $user_id;
                                    $_SESSION['token'] = $token;

                                    // Отправка подтверждающего письма
                                    header("Location: /cw/email/email_sender.php?user_username={$username}&email={$email}&token={$token}");

                                } else {
                                    $error = "Возникла ошибка при регистрации (попробуйте позже): ";
                                    handl_error($error, $e->getMessage());
                                    exit();
                                }
                            }
                        } catch (Exception $e) {
                            $error = "Возникла ошибка при регистрации (попробуйте позже): ";
                            handl_error($error, $e->getMessage());
                            exit();
                        } finally {
                            if (isset($stmt_check))
                                mysqli_stmt_close($stmt_check);
                            if (isset($stmt_user))
                                mysqli_stmt_close($stmt_user);
                            if (isset($conn))
                                mysqli_close($conn);
                        }
                    }
                    ?>

                    <?php if ($error || $success): ?>
                    <p class="caption mb-4" style="color: <?php echo $error ? 'red' : 'green'; ?>;" id="message">
                        <?php echo htmlspecialchars($error ? $error : $success); ?>
                    </p>
                    <script>
                        $(document).ready(function () {
                            setTimeout(function () {
                                $('#message').hide();
                            }, 5000);
                        });
                    </script>
                <?php endif; ?>


                <form action="signup.php" method="POST" enctype="multipart/form-data" class="pt-3">

                    <div class="form-floating">
                        <input class="form-control" type="text" autocomplete="on" name="name" minlength="3"
                            maxlength="100" required pattern="^[A-Za-zА-Яа-яЁё\s]*$" id="name" placeholder="Имя"
                            value="<?php echo htmlspecialchars($name); ?>">
                        <label for="name">Имя</label>
                    </div>

                    <div class="form-floating">
                        <input class="form-control" type="text" autocomplete="on" name="username" id="username"
                            minlength="3" maxlength="20" required pattern="^[\w]+$" placeholder="Логин"
                            value="<?php echo htmlspecialchars($username); ?>">
                        <label for="username">Логин</label>
                    </div>

                    <div class="form-floating">
                        <input class="form-control" type="email" autocomplete="on" name="email" id="email" required
                            placeholder="Электронная почта" value="<?php echo htmlspecialchars($email); ?>">
                        <label for="email">Электронная почта</label>
                    </div>

                    <p class="caption mb-4">Пароль должен содержать заглавную и строчную букву, цифру и специальный
                        символ</p>

                    <div class="form-floating">
                        <span class="password-show-toggle js-password-show-toggle"><span class="uil"></span></span>
                        <input class="form-control" type="password" id="password" minlength="8" maxlength="40" required
                            pattern="^(?=.*[A-Z])(?=.*[\d])(?=.*[a-z])(?=.*[\W])[a-zA-Z\d\W]{6,20}$"
                            placeholder="Пароль" name="password" oninput="checkpass(document.getElementById('validate-password').value)">
                        <label for="password">Пароль</label>
                    </div>

                    <div class="form-floating">
                        <span class="password-show-toggle js-password-show-toggle"><span class="uil"></span></span>
                        <input class="form-control" type="password" id="validate-password" minlength="8" maxlength="40" required
                            pattern="^(?=.*[A-Z])(?=.*[\d])(?=.*[a-z])(?=.*[\W])[a-zA-Z\d\W]{6,20}$"
                            placeholder="Пароль" name="validate-password" oninput="checkpass(this.value)">
                        <label for="validate-password">Подтверждение пароля</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label for="remember" class="form-check-label">Я соглашаюсь с <a href="#">политикой
                                    конфиденциальности</a></label>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary">Создать аккаунт</button>
                    </div>

                    <div class="mb-2">Уже есть аккаунт?<a href="signin.php"> Войти</a></div>

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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
</body>

</html>