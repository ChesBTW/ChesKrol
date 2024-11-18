<?php
session_start();
session_unset(); // Удалить все переменные сессии.
session_destroy(); // Уничтожить сессию.
header("Location: index.php"); // Перенаправление на главную страницу
exit();
?>