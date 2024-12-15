<?php
require_once '../db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Удаляем аватар пользователя
$query = "SELECT photo FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($photo);
$stmt->fetch();
$stmt->close();

if ($photo && file_exists("../images/users/" . $photo)) {
    unlink("../images/users/" . $photo);
}

// Удаляем пользователя из БД
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    session_destroy();
    $_SESSION['toast'] = ['type' => 'success', 'message' => 'Аккаунт успешно удален.'];
    header('Location: ../index.php');
} else {
    $_SESSION['toast'] = ['type' => 'error', 'message' => 'Ошибка при удалении аккаунта.'];
    header('Location: ../account.php');
}
exit();
?>