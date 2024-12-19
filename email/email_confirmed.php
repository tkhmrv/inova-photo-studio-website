<?php
// Подключение к базе данных
require '../db_connection.php';

// Получаем токен из URL
$token = $_GET['token'] ?? null;

if ($token) {
  // Проверка токена в базе данных
  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE token = ?");
  mysqli_stmt_bind_param($stmt, "s", $token);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    if ($user['email_verified'] == 1) {
      // Если почта уже подтверждена
      header("Location: email_confirmed_page.php?status=already_verified");
      exit();
    } else {
      // Обновляем статус подтверждения
      $stmt = mysqli_prepare($conn, "UPDATE users SET email_verified = 1 WHERE token = ?");
      mysqli_stmt_bind_param($stmt, "s", $token);
      mysqli_stmt_execute($stmt);

      // Перенаправление на страницу с сообщением об успешном подтверждении
      header("Location: email_confirmed_page.php?status=success");
      exit();
    }
  } else {
    // Если токен не найден
    header("Location: email_confirmed_page.php?status=invalid_token");
    exit();
  }

  mysqli_stmt_close($stmt); // Corrected function name
} else {
  // Если токен отсутствует в URL
  header("Location: email_confirmed_page.php?status=no_token");
  exit();
}
?>