<?php
require_once 'functions.php';

// Настройки подключения к базе данных
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password_db = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// Подключение к базе данных
try {
  $conn = mysqli_connect($servername, $username, $password_db, $dbname);

  // Проверка подключения
  if (mysqli_connect_errno()) {
    throw new Exception("Не удалось подключиться к базе данных: " . mysqli_connect_error());
  }
} catch (Exception $e) {
  // В случае ошибки перенаправляем на страницу с сообщением об ошибке
  $error = "Возникла ошибка при подключении к базе данных: ";
  handl_error($error, $e->getMessage());
  exit();
}