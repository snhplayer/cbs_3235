<?php
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

session_start();
$savedCode = $_SESSION['verificationCode'] ?? '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'];

    if ($enteredCode == $savedCode) {

        $username=$_SESSION['username'] ?? '';
        $password=$_SESSION['password'] ?? '';
        $telegram=$_SESSION['telegram'] ?? '';

        if ($username) {
            $passwordHash = hash('sha256', $password);
        
		    $stmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash, Telegram) VALUES (?, ?, ?)");
		    $stmt->bind_param("sss", $username, $passwordHash, $telegram);
		    $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = "Учетная запись активирована!\n";
                //header("Location: login.php");
                exit($response);
            } else {
                
                $response = "Ошибка активации учетной записи.";
            }
        } else {
           
            $response = "Ошибка сессии. Пожалуйста, попробуйте зарегистрироваться снова.";
        }
    } else {
      
        $response = "Неверный код подтверждения.";
    }
exit($response);

$stmt->close();
$conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Проверка кода</title>
<style>
   
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

  
    #verifyForm {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 300px; 
    }

    h2 {
        text-align: center;
        color: #333;
    }

    #verifyForm input {
        width: 100%; 
        max-width: 275px; 
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    #verifyForm input[type="submit"] {
        background-color: #0056b3;
        color: white;
        border: none;
        cursor: pointer;
        max-width: 295px; 
        padding: 10px;
        border-radius: 4px;
    }

    #verifyForm input[type="submit"]:hover {
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




<form id="verifyForm" method="post">
    <!-- Поля формы -->
    <input type="text" name="code" required placeholder="Проверочный код">
    <input type="submit" value="Проверить код">
</form>

<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <p id="popup-message"></p>
    </div>
</div>

<script>
let lastResponse = '';




document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('verifyForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this);

            fetch('verify.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                lastResponse = data;
                
                showPopup(data);
            })
            .catch(error => console.error('Ошибка:', error));
        });
    }
});


function showPopup(message) {
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popup-message');
    if(popup && popupMessage) {
        popupMessage.textContent = message;
        popup.style.display = 'flex';
    }
}


function closePopup() {
    var popup = document.getElementById('popup');
    if(popup) {
        popup.style.display = 'none';
    }
    if (lastResponse.includes("Учетная запись активирована!")) {
        window.location.href = 'login.php'; 
    }
}
</script>

</body>
</html>