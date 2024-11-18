<?php
session_start();
$mysqli = new mysqli("MySQL-8.2", "root", "", "cheskrol");

// Проверяем успешное подключение к базе данных
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Инициализация переменных
$username = $_SESSION['username'] ?? null; // Установите значение по умолчанию на null
$clicks = 0;

if ($username) {
    // Получаем количество кликов пользователя
    $query = "SELECT click_count FROM users WHERE username='$username'";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $clicks = $user['click_count'];
    }
}

// Обработка кликов
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['click'])) {
    // Увеличиваем счетчик кликов
    if ($username) {
        $clicks++; // Увеличиваем количество кликов
        // Обновляем количество кликов пользователя в таблице users
        $query = "UPDATE users SET click_count=$clicks WHERE username='$username'";
        $mysqli->query($query);
    }
}

// Получаем таблицу лидеров из таблицы users, теперь с лимитом 10
$leaderboard = $mysqli->query("SELECT username, click_count AS clicks FROM users ORDER BY click_count DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ChesKrol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <h1>Ches<span style="color:red;">Krol</span></h1>
        <nav>
            <a href="#">Топ</a>
            <a href="#">Магазин</a>
            <a href="register.php">Регистрация</a>
            <a href="login.php">Вход</a>
        </nav>
        <?php if ($username): ?>
            <div class="user-info">
                Привет, <?php echo htmlspecialchars($username ?? ''); ?>!
                <a href="logout.php">Выход</a>
            </div>
        <?php endif; ?>
    </header>

    <main>
        <div class="content">
            <div class="bunny-container">
                <form method="post">
                    <button type="submit" name="click" value="1" class="bunny-button">
                        <img src="images/bunny.png" alt="Кролик" class="bunny" style="width: 500px; height:300px;">
                    </button>
                </form>
                <div class="counter">
                    Клики: <?php echo htmlspecialchars($clicks ?? 0); ?> <span class="icon">🐇</span>
                </div>
            </div>

            <div class="leaderboard">
                <h2>Топ игроков</h2>
                <ol>
                <?php while ($row = $leaderboard->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['username'] ?? ''); ?>: <?php echo htmlspecialchars($row['clicks'] ?? 0); ?></li>
                <?php endwhile; ?>
                </ol>
            </div>

            <?php if ($username): ?>
                <div class="user-stats">
                    <h3>Ваши достижения</h3>
                    <p><?php echo htmlspecialchars($username); ?>: <?php echo htmlspecialchars($clicks); ?> кликов</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <footer>
        <p>&copy; 2024 ChesKrol. Все права защищены.</p>
    </footer>
</body>
</html>