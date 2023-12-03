<?php
// Подключение к базе данных
$host = 'localhost';
$database = 'cbs';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movieId = $_POST['session-movie'];
    $sessionTime = $_POST['session-time'];

    $stmt = $conn->prepare("INSERT INTO sessions (MovieID, SessionTime) VALUES (?, ?)");
    $stmt->bind_param("is", $movieId, $sessionTime);

    if ($stmt->execute()) {
        $newSessionId = $conn->insert_id; // Получаем ID добавленного сеанса
        echo json_encode(['status' => 'success', 'message' => 'Сеанс успешно добавлен', 'sessionId' => $newSessionId, 'sessionInfo' => "Фильм ID $movieId - $sessionTime"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при добавлении сеанса']);
    }

    $stmt->close();
    $conn->close();
}
?>
