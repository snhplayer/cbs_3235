
<?php

$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn = mysqli_connect("localhost", "root", "", "cbs");

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE Username='$username'";

  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    $hashedPassword = $user['PasswordHash'];
    $inputHash = hash('sha256', $password);

    if($inputHash === $hashedPassword) {
      
      setcookie('user_id', $user['UserID'], time() + 3600); 
      setcookie('username', $user['Username'], time() + 3600);
      setcookie('telegram_id', $user['Telegram'], time() + 3600);
      
      $response = "Вход успешен! Добро пожаловать, ".$user['Username'];
    } else {
      $response = "Неверный пароль!";
    }

  } else {
    $response = "Пользователь с таким именем не найден!";
  }
  exit($response);
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

    
    #loginForm {
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

    #loginForm input {
        width: 100%; 
        max-width: 275px; 
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    #loginForm input[type="submit"] {
        background-color: #0056b3;
        color: white;
        border: none;
        cursor: pointer;
        max-width: 295px; 
        padding: 10px;
        border-radius: 4px;
    }

    #loginForm input[type="submit"]:hover {
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
    <form id="loginForm" action="" method="post">
        <label for="username">Имя пользователя:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Войти">
    </form>

   
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <p id="popup-message"></p>
        </div>
    </div>
    <input type="hidden" id="usrnm" value="<?php $username; ?>">
<script>
let lastResponse = '';
let username = document.getElementById('usrnm').value;
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('loginForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this);

            fetch('login.php', { 
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
    if (lastResponse.includes(`Вход успешен! Добро пожаловать, ${username}`)){
        window.location.href = 'userpanel.php'; // Перенаправление
    }
}
</script>
</body>
</html>
