<!DOCTYPE html>
<html>
<head>
    <title>Главная Страница - Кинотеатр</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .welcome-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin: 10px;
            text-decoration: none; /* Убрать подчеркивание для ссылок */
        }

        .button:hover {
            background-color: #004494;
        }
    </style>
</head>
<?php
session_start(); // Начало сессии для отслеживания пользователя
if (isset($_COOKIE['user_id']) && isset($_COOKIE['username']) && isset($_COOKIE['telegram_id'])) {
    $_SESSION['loggedin'] = true;
} else {
    $_SESSION['loggedin'] = false;
}

if (isset($_COOKIE['user_id'])) {
    header("Location: userpanel.php");
    exit();
} else {
    echo "<div class='welcome-container'>
            <h1>Добро пожаловать в Кинотеатр!</h1>
            <a href='login.php' class='button'>Вход</a>
            <a href='register.php' class='button'>Регистрация</a>
          </div>";
}
?>

</body>
</html>
</html>
