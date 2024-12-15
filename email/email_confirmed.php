<?php
// Подключение к базе данных
require '../db_connection.php';

$token = $_GET['token'] ?? null;

if ($token) {
  // Проверка токена
  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE token = ?");
  mysqli_stmt_bind_param($stmt, "s", $token);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    // Подтверждение email
    $stmt = mysqli_prepare($conn, "UPDATE users SET email_verified = 1 WHERE token = ?");
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);

    echo "Email успешно подтвержден!";
  } else {
    echo "Неверный токен.";
  }

  mysqli_stmt_close($stmt);
} else {
  echo "Токен не найден.";
}
