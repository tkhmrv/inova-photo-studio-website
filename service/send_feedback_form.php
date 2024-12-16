<?php
session_start();
require_once '../db_connection.php'; // Подключение к базе данных

// Проверяем, отправлена ли форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем и очищаем данные из формы
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Валидация данных
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Все поля формы обязательны для заполнения.',
        ];
        header('Location: ../contacts.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Неверный формат электронной почты.',
        ];
        header('Location: ../contacts.php');
        exit();
    }

    if (strlen($name) < 3 || strlen($subject) < 3 || strlen($message) > 200) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Убедитесь, что длина данных соответствует требованиям.',
        ];
        header('Location: ../contacts.php');
        exit();
    }

    // Подготовка запроса
    $query = "INSERT INTO feedback_form (sender_name, sender_email, topic, message) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Ошибка подготовки запроса: ' . $conn->error,
        ];
        header('Location: ../contacts.php');
        exit();
    }

    // Привязываем параметры
    $stmt->bind_param('ssss', $name, $email, $subject, $message);

    // Выполняем запрос
    if ($stmt->execute()) {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Ваше сообщение успешно отправлено. Спасибо за ваш отзыв!',
        ];
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Ошибка при отправке данных: ' . $stmt->error,
        ];
    }

    // Закрываем соединение
    $stmt->close();
    $conn->close();

    // Перенаправление обратно на страницу формы
    header('Location: ../contacts.php');
    exit();
} else {
    $_SESSION['toast'] = [
        'type' => 'error',
        'message' => 'Неверный метод запроса.',
    ];
    header('Location: ../contacts.php');
    exit();
}