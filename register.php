<?php
session_start();
$mysqli = new mysqli("MySQL-8.2", "root", "", "cheskrol");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хеширование пароля

    // Проверка, существует ли уже пользователь
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $mysqli->query($query);
    
    if ($result->num_rows > 0) {
        echo "Пользователь с таким именем уже существует!";
    } else {
        // Вставка нового пользователя
        $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        echo "Регистрация прошла успешно!";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <form method="post">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required>
        
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>