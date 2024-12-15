<?php
session_start();
require_once '../db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем авторизацию
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Вы должны быть авторизованы для добавления комментариев.']);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $post_slug = $_POST['post_slug'] ?? '';
    $message = $_POST['message'] ?? '';

    // Проверяем валидность данных
    if (empty($post_slug) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения.']);
        exit();
    }

    // Вставляем комментарий в базу данных
    $query = "INSERT INTO comments (user_id, post_slug, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $user_id, $post_slug, $message);

    if ($stmt->execute()) {
        // Получаем данные о пользователе
        $query_user = "SELECT name, photo FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($query_user);
        $stmt_user->bind_param('i', $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();

        echo json_encode([
            'success' => true,
            'comment' => [
                'name' => $user['name'],
                'photo' => $user['photo'],
                'message' => htmlspecialchars($message),
                'date' => date('d F Y в H:i'),
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка добавления комментария.']);
    }
    exit();
}
