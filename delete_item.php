<?php
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['type'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type == 'movie') {
        // Предполагаем, что сначала нужно удалить все сеансы и бронирования, связанные с фильмом
        $conn->begin_transaction();
        try {
            // Удаление всех сеансов и бронирований для данного фильма
            $stmt = $conn->prepare("DELETE FROM bookings WHERE SessionID IN (SELECT SessionID FROM sessions WHERE MovieID = ?)");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM sessions WHERE MovieID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Теперь можно удалить сам фильм
            $stmt = $conn->prepare("DELETE FROM movies WHERE MovieID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $conn->commit();
            echo "Фильм и связанные сеансы и бронирования удалены";
        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            echo "Ошибка при удалении фильма: " . $exception->getMessage();
        }
    } else if ($type == 'session') {
        // Удаление всех бронирований для данного сеанса, а затем самого сеанса
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("DELETE FROM bookings WHERE SessionID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM sessions WHERE SessionID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $conn->commit();
            echo "Сеанс и связанные бронирования удалены";
        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            echo "Ошибка при удалении сеанса: " . $exception->getMessage();
        }
    } else {
        echo "Неверный тип";
    }

    $conn->close();
}
?>