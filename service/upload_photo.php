<?php
session_start();

header('Content-Type: application/json');

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Проверяем, загружен ли файл
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Ошибка загрузки файла.']);
    exit();
}

$file = $_FILES['photo'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 2 * 1024 * 1024; // 2MB

// Проверяем тип и размер файла
if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Недопустимый формат файла.']);
    exit();
}

if ($file['size'] > $max_size) {
    echo json_encode(['success' => false, 'message' => 'Файл превышает максимально допустимый размер (2Мб).']);
    exit();
}

// Генерируем уникальное имя для файла
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $user_id . '_' . time() . '.' . $ext;
$upload_path = '../images/users/' . $filename;

// Сохраняем файл
if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
    echo json_encode(['success' => false, 'message' => 'Не удалось сохранить файл.']);
    exit();
}

// Обновляем запись в базе данных
require_once '../db_connection.php';
$query = "UPDATE users SET photo = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $filename, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'filename' => $filename]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка обновления записи в базе данных.']);
}
?>