<?php
// Подключение к базе данных
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}



if(!isset($_COOKIE['user_id'])) {
  header('Location: index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    
    //setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_id', '', time() - 3600); 

    header('Location: index.php');
    exit();
}

$user_id = $_COOKIE['user_id'];

$query = $conn->prepare("SELECT isAdmin FROM users WHERE UserID = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row["isAdmin"] == 1) {
        
        header("Location: admin.php");
        exit();
    }
} else {
    
    echo "Произошла ошибка.";
    exit();
}

?>






<!DOCTYPE html>
<html>
<head>
    <title>Личный Кабинет</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .user-account {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .account-section {
            margin-bottom: 20px;
        }

        .account-section label {
            display: block;
            margin-bottom: 5px;
        }
        
        .scrollable-section {
            max-height: 300px; /* или другая высота по вашему выбору */
            overflow-y: auto; /* Включает вертикальный скроллинг */
            overflow-x: hidden; /* Предотвращает горизонтальный скроллинг */
            -ms-overflow-style: none; /* Для IE и Edge */
            scrollbar-width: none; /* Для Firefox */
        }

        .scrollable-section::-webkit-scrollbar {
            display: none; /* Для Chrome, Safari и Opera */
        }
        .account-section input, .account-section p {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            max-width: 350px;
        }

        .account-section button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .account-section button:hover {
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

<div class="user-account">
    <h2>Добро пожаловать, <?php echo $_COOKIE['username'] ?></h2>

    <div class="account-section">
        <label>Telegram ID:</label>
        <p>@<?php echo $_COOKIE['telegram_id'] ?></p>
    </div>

<h3>История бронирований</h3>
    <div class="account-section scrollable-section">
        
        <?php
    $userId = $_COOKIE['user_id']; // Или другой способ получения ID пользователя
    $query = "SELECT m.Title, s.SessionTime, b.RowNumber, b.SeatNumber
              FROM bookings b
              JOIN sessions s ON b.SessionID = s.SessionID
              JOIN movies m ON s.MovieID = m.MovieID
              WHERE b.UserID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>Фильм: " . htmlspecialchars($row['Title']) . "<br>";
                echo "Время сеанса: " . htmlspecialchars($row['SessionTime']) . "<br>";
                echo "Ряд: " . htmlspecialchars($row['RowNumber']) . ", Место: " . htmlspecialchars($row['SeatNumber']) . "</p>";
            }
        } else {
            echo "<p>Бронирований не найдено.</p>";
        }
        $stmt->close();
    }
    ?>
    </div>

	<div class="account-section">
        <form action="movielist.php" method="get"> <!-- Предполагаем, что booking_page.php - это ваша страница бронирования -->
            <button type="submit">Перейти к бронированию</button>
        </form>
	    <form action="userpanel.php" method="post">
	        <button type="submit" name="logout">Выйти</button>
	    </form>

	</div>
</div>



</body>
</html>
