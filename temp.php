<?php
// Подключаем файл подключения к базе данных
require_once 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Регистрация пользователя</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

<?php include 'templates/header.php'; ?>

  <div class="wrapper">
    <main class="page page-center">
      <div class="container">
        
        <section class="info">
          <h1>Фотостудия</h1>
          <h2>Регистрация</h2>
        </section>

        <?php
        // Инициализация переменных для формы
        $first_name = '';
        $last_name = '';
        $email = '';
        $user_username = '';
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          // Получение данных из формы и Фильтрация данных
          $first_name = filter_input(INPUT_POST, 'first_name', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/(^[A-Za-z]+$)|(^[А-ЯЁа-яё]+$)/u')));
          $last_name = filter_input(INPUT_POST, 'last_name', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/(^[A-Za-z]+$)|(^[А-ЯЁа-яё]+$)/u')));
          $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
          $user_username = filter_input(INPUT_POST, 'user_username', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w]+$/')));
          $user_password = $_POST['password'];
          $name_foto = basename($_FILES["user_pic"]["name"]);

          // Проверяем, что поля не пустые и корректны
          if (!$first_name || !$last_name || !$email || !$user_username || !$user_password) {
            die("Некорректные данные. Проверьте заполнение формы.");
          }

          // Хеширование пароля
          $password_hash = password_hash($user_password, PASSWORD_DEFAULT);

          try {
            // Проверка, существует ли уже пользователь с таким логином или email
            $query_check_user = "SELECT * FROM user WHERE username = ? OR e_mail = ?";
            $stmt_check = mysqli_prepare($conn, $query_check_user);
            mysqli_stmt_bind_param($stmt_check, 'ss', $user_username, $email);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);

            if (mysqli_stmt_num_rows($stmt_check) > 0) {
              $error = "Пользователь с таким логином или email уже существует.";
            } else {
              $token = bin2hex(random_bytes(15)); //сгенерируем токен

              // Запись в базу данных
              $query_user = "INSERT INTO user(
              first_name, 
              last_name, 
              username, 
              password, 
              foto, 
              e_mail, 
              date_of_creation, 
              check_mail, 
              token) 
            VALUES(?, ?, ?, ?, ?, ?, NOW(), 1, ?)";

              $stmt_user = mysqli_prepare($conn, $query_user);
              mysqli_stmt_bind_param(
                $stmt_user,
                'sssssss',
                $first_name,
                $last_name,
                $user_username,
                $password_hash,
                $name_foto,
                $email,
                $token
              );

              $msqq = mysqli_stmt_execute($stmt_user);

              if ($msqq) {
                $user_id = strval(mysqli_insert_id($conn));

                $_SESSION['user_id'] = $user_id;
                $_SESSION['token'] = $token;

                // Загрузка файла аватарки
                $target_dir = "uploads/" . $user_id . "_";
                $target_file = $target_dir . basename($_FILES["user_pic"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if (isset($_POST["submit"])) {
                  $check = getimagesize($_FILES["user_pic"]["tmp_name"]);
                  if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                  } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                  }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                  echo "Sorry, file already exists.";
                  $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["user_pic"]["size"] > 500000) {
                  echo "Sorry, your file is too large.";
                  $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                  $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                  && $imageFileType != "gif"
                ) {
                  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                  $uploadOk = 0;
                }

                if (move_uploaded_file($_FILES["user_pic"]["tmp_name"], $target_file)) {
                  $success = "Регистрация успешна!";

                  // Отправка подтверждающего письма
                  header("Location: /cw/main-site/email/send_mail.php?user_username={$user_username}&email={$email}&token={$token}");
                  exit();
                } else {
                  $error = "Ошибка загрузки файла.";
                }
              } else {
                $error = "Возникла ошибка при регистрации(попробуйте позже): ";
                handl_error($error, $e->getMessage());
                exit();
              }

              // Закрытие соединения
              mysqli_stmt_close($stmt_check);
              mysqli_stmt_close($stmt_user);
            }
          } catch (Exception $e) {
            $error = "Возникла ошибка при регистрации и  (попробуйте позже): ";
            handl_error($error, $e->getMessage());
            exit();
          }

          mysqli_close($conn);
        }
        ?>

        <form action="register.php" method="POST" enctype="multipart/form-data" oninput="valid_for  m()">
          <!-- Сообщение об ошибке -->
          <?php if ($error): ?>
            <div class="error-message" style="color: red;">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>

          <!-- Сообщение об успешной регистрации -->
          <?php if ($success): ?>
            <div class="success-message" style="color: green;">
              <?php echo $success; ?>
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="first_name">Имя:
              <input autocomplete="on" type="text" name="first_name" minlength="3" maxlength="20" required
                pattern="(^[A-Za-z]+$)|(^[А-ЯЁа-яё]+$)" id='user_name' placeholder="Обязательное поле"
                value="<?php echo htmlspecialchars($first_name); ?>">
              <span class="icon fa fa-check valid-i" id='valid_user_name'></span>
              <span class="icon fa fa-times invalid-i" id='invalid_user_name'></span>
            </label>
            <div class="hint">Введите имя латинскими или русскими буквами, минимум 3 буквы, максимум 20 букв</div>
          </div>

          <div class="form-group">
            <label for="last_name">Фамилия:
              <input autocomplete="on" type="text" name="last_name" required pattern="(^[A-Za-z]+$)|(^[А-ЯЁа-яё]+$)" minlength="3"
                maxlength="20" placeholder="Обязательное поле" id="user_last_name"
                value="<?php echo htmlspecialchars($last_name); ?>">
              <span class="icon fa fa-check valid-i" id='valid_user_last_name'></span>
              <span class="icon fa fa-times invalid-i" id='invalid_user_last_name'></span>
            </label>
            <div class="hint">Введите фамилию латинскими или русскими буквами, минимум 3 буквы, максимум 20 букв</div>
          </div>

          <div class="form-group">
            <label for="user_pic">Изображение профиля:
              <input type="file" name="user_pic" size="50" required id="user_pic">
              <!-- <span class="icon fa fa-check valid-i" id='valid_user_pic'></span>
              <span class="icon fa fa-times invalid-i" id='invalid_user_pic'></span> -->
            </label>
            <div class="hint">Выберите изображение в формате jpeg или bmp, размером не более 2 Мб</div>
          </div>

          <div class="form-group">
            <label for="email">E-mail:
              <input autocomplete="on" type="email" name="email" id="email" required placeholder="Обязательное поле"
                value="<?php echo htmlspecialchars($email); ?>">
              <span class="icon fa fa-check valid-i" id='valid_e_mail'></span>
              <span class="icon fa fa-times invalid-i" id='invalid_e_mail'></span>
            </label>
          </div>

            <div class="form-group">
                <label for="user_username">Логин:
                <input autocomplete="on" type="text" name="user_username" minlength="3" maxlength="20" required id="user_username"
                    pattern="^[\w]+$" placeholder="Обязательное поле"
                    value="<?php echo htmlspecialchars($user_username); ?>">
                <span class="icon fa fa-check valid-i" id='valid_user_username'></span>
                <span class="icon fa fa-times invalid-i" id='invalid_user_username'></span>
                </label>

            <div class="hint">От 3 до 20 символов: цифр, английских букв и знака _</div>
          </div>

          <div class="form-group">
            <label for="password">Пароль:
              <input type="password" name="password" minlength="6" maxlength="20" required id="password"
                oninput="checkpass(document.getElementById('pass2').value)"
                pattern="^(?=.*[A-Z])(?=.*[\d])(?=.*[a-z])(?=.*[\W])[a-zA-Z\d\W]{6,20}$"
                placeholder="Обязательное поле">
              <span class="icon fa fa-check valid-i" id='valid_password'></span>
              <span class="icon fa fa-times invalid-i" id='invalid_password'></span>
            </label>

            <div class="hint">От 6 до 20 символов, обязательно одна заглавная и строчная английская буква, одна цифра и
              один спец. символ. Русские буквы не допускаются</div>
          </div>

          <div class="form-group">
            <label for='pass2'>Повторите пароль:
              <input type="password" id="pass2" required placeholder="Обязательное поле"
                oninput="checkpass(this.value)">
              <span class="icon fa fa-check valid-i" id='valid_pass2'></span>
              <span class="icon fa fa-times invalid-i" id='invalid_pass2'></span>
            </label>
          </div>

          <div class="buttons">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            <button type="reset" class="btn btn-secondary">Очистить</button>
            <a href="login.php" class="btn btn--link">Войти</a>
          </div>
        </form>

      </div>
    </main>
  </div>

  <?php include 'templates/footer.php'; ?>

  <script src="validInput.js"></script>
</body>

</html>