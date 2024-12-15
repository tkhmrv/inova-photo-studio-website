<?php
require_once '../db_connection.php';
session_start();

// Проверяем авторизацию пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$website = $_POST['website'];

// Проверяем введенные данные
if (empty($name) || empty($username) || empty($email)) {
    die("Все поля обязательны для заполнения.");
}

// Обновляем данные пользователя
$query = "UPDATE users SET name = ?, username = ?, email = ?, website = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssssi', $name, $username, $email, $website, $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Информация успешно обновлена.";
} else {
    $_SESSION['error'] = "Ошибка при обновлении данных.";
}

header('Location: ../account.php');
exit();
?>