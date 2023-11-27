<?php

$dbHost = 'localhost';
$dbName = 'cbs'; 
$dbUser = 'root';
$dbPass = '';


$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName); 


if(!$conn) {
  die("Ошибка: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$row = $_POST['row'];
	$seat = $_POST['seat'];
	$sessionId = $_POST['sessionId'];
	$bookingTime = $_POST['bookingTime'];
	$user_id = $_POST['user_id'];
	
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