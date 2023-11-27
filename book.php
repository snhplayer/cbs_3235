<?php
// Подключение к базе данных
$dbHost = 'localhost';
$dbName = 'cbs'; 
$dbUser = 'root';
$dbPass = '';

// Подключение к БД
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName); 

// Проверка подключения
if(!$conn) {
  die("Ошибка: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Получение данных из AJAX-запроса
	$row = $_POST['row'];
	$seat = $_POST['seat'];
	$sessionId = $_POST['sessionId'];
	$bookingTime = $_POST['bookingTime'];
	$user_id = $_POST['user_id'];
	// Вставка данных в таблицу
	$query = "INSERT INTO bookings ( SessionID, UserID, RowNumber, SeatNumber, BookingTime) VALUES (?, ?, ?, ?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iiisi", $sessionId, $user_id, $row, $seat, $bookingTime);

	if ($stmt->execute()) {
	    echo "Успешное бронирование";
	} else {
	    echo "Ошибка: " . $stmt->error;
	}

	$stmt->close();
	$conn->close();
}
?>