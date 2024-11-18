<?php
session_start();
$mysqli = new mysqli("MySQL-8.2", "root", "", "cheskrol");

if (!isset($_SESSION['username'])) {
    exit("Вы не авторизованы!");
}

$username = $_SESSION['username'];

// Увеличение счетчика кликов
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['click'])) {
    // Увеличиваем счетчик кликов
    if ($username) {
        $clicks++;
        // Обновляем количество кликов пользователя в таблице users
        $query = "UPDATE users SET click_count=$clicks WHERE username='$username'";
        $mysqli->query($query);

        // Обновление таблицы лидеров с использованием обновленного количества кликов пользователя
        $stmt = $mysqli->prepare("INSERT INTO leaderboard (username, clicks) VALUES (?, ?) ON DUPLICATE KEY UPDATE clicks = ?");
        $stmt->bind_param("sii", $username, $clicks, $clicks);
        $stmt->execute();
    }
}

// Получаем таблицу лидеров, теперь с лимитом 10
$leaderboard = $mysqli->query("SELECT username, clicks FROM leaderboard ORDER BY clicks DESC LIMIT 10");

header("Location: index.php"); // Перенаправление на главную страницу
exit();
?>