<?php
session_start();
$mysqli = new mysqli("MySQL-8.2", "root", "", "cheskrol");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $mysqli->query($query);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Проверка пароля
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Перенаправление на главную страницу
            exit();
        } else {
            echo "Неправильный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <form method="post">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required>
        
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Войти</button>
    </form>
</body>
</html>