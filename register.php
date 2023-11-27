<?php
// Подключение к базе данных
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs';
// Создание подключения к базе данных
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $telegram = $_POST['telegram'];

    // Проверка на уникальность пользователя
    $checkUser = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        die("Пользователь с таким именем уже существует.");
    }


    if ($result->num_rows == 0) {
        session_start();
        $response = "Регистрация успешна. Код подтверждения отправлен в Telegram.";

        $token = "6548654830:AAGKqmo6Z2R-SaGnKpknrkt-SLWd3yeL5Zw";
        $updates = getTelegramUpdates($token);
        $verificationCode = generateVerificationCode();
        $_SESSION['verificationCode']=$verificationCode;
        $_SESSION['username']=$username;
        $_SESSION['password']=$password;
        $_SESSION['telegram']=$telegram;
        $chat_id = $telegram; // ID пользователя Telegram, полученный из формы
        $message = "Ваш код подтверждения: `" . $verificationCode . "`";
        $message = urlencode($message);
        // Просмотреть все обновления и найти chat_id
        foreach ($updates['result'] as $update) {
            if (isset($update['message']['chat']['id']) && isset($update['message']['chat']['username'])) {
                if ($update['message']['chat']['username'] == $telegram) {
                    $chat_id = $update['message']['chat']['id'];
                    $urlQuary = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&parse_mode=MARKDOWN&text=" . $message;
                    file_get_contents($urlQuary);
                }
            }
        }

    } else {
        $response = "Ошибка при регистрации.";
    }

    // Отправка ответа
    exit($response);

    $stmt->close();
    $conn->close();
}

function generateVerificationCode($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getTelegramUpdates($botToken) {
    $url = "https://api.telegram.org/bot$botToken/getUpdates";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
<style>
    /* Стили для всплывающего окна */
    .popup {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }
    .popup-content {
        background: white;
        padding: 20px;
        border-radius: 5px;
        position: relative;
    }
    .close-btn {
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 5px;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Стили для формы */
    #registrationForm {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 300px; /* Можно изменить ширину формы, если нужно */
    }

    h2 {
        text-align: center;
        color: #333;
    }

    #registrationForm input {
        width: 100%; /* Установите фиксированную ширину здесь, если нужно */
        max-width: 275px; /* Максимальная ширина полей ввода */
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    #registrationForm input[type="submit"] {
        background-color: #0056b3;
        color: white;
        border: none;
        cursor: pointer;
        max-width: 295px; /* Максимальная ширина кнопки */
        padding: 10px;
        border-radius: 4px;
    }

    #registrationForm input[type="submit"]:hover {
        background-color: #004494;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.8em;
    }
</style>
</head>
<body>

<!-- Форма регистрации -->


<form id="registrationForm" method="post">
    <!-- Поля формы -->
    <input type="text" name="username" required placeholder="Имя пользователя">
    <input type="password" name="password" required placeholder="Пароль">
    <input type="text" name="telegram" required placeholder="Telegram ID">
    <input type="submit" value="Зарегистрироваться">
</form>

<!-- Всплывающее окно -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <p id="popup-message"></p>
    </div>
</div>

<script>
let lastResponse = '';

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('registrationForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Предотвращение стандартной отправки формы
            var formData = new FormData(this);

            fetch('register.php', { // Убедитесь, что путь указан правильно
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                lastResponse = data;
                // Отображение сообщения в всплывающем окне
                showPopup(data);
            })
            .catch(error => console.error('Ошибка:', error));
        });
    }
});

// Функция для отображения всплывающего окна
function showPopup(message) {
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popup-message');
    if(popup && popupMessage) {
        popupMessage.textContent = message;
        popup.style.display = 'flex';
    }
}

// Функция для закрытия всплывающего окна
function closePopup() {
    var popup = document.getElementById('popup');
    if(popup) {
        popup.style.display = 'none';
    }
    if (lastResponse.includes("Код подтверждения отправлен в Telegram")) {
        window.location.href = 'verify.php'; // Перенаправление
    }
}
</script>

</body>
</html>
