<?php
require_once '../db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$current_password = $_POST['currentPassword'];
$new_password = $_POST['password'];

// Проверяем текущий пароль
$query = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

if (!password_verify($current_password, $hashed_password)) {
    $_SESSION['toast'] = ['type' => 'error', 'message' => 'Неверный текущий пароль.'];
    header('Location: ../account.php#password');
    exit();
}

// Обновляем пароль
$new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
$query = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $new_hashed_password, $user_id);

if ($stmt->execute()) {
    $_SESSION['toast'] = ['type' => 'success', 'message' => 'Пароль успешно обновлен.'];
} else {
    $_SESSION['toast'] = ['type' => 'error', 'message' => 'Ошибка обновления пароля.'];
}

header('Location: ../account.php#password');
exit();
?>