<?php
$DB_HOST = 'MySQL-8.2'; // Или '127.0.0.1'
$DB_USER = 'root'; // Имя пользователя базы данных
$DB_PASS = ''; // Пароль к базе данных
$DB_NAME = 'cheskrol'; // Имя базы данных

// Подключение к базе данных
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Установка кодировки
$mysqli->set_charset("utf8mb4");
?>