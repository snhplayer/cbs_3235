<?php
// Подключение к базе данных
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['movie-title'];
    $description = $_POST['description'];
    $newpath = null;

    // Обработка загрузки изображения
    if (isset($_FILES['movie-image']) && $_FILES['movie-image']['error'] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES['movie-image']['name'];
        $filetype = $_FILES['movie-image']['type'];
        $filesize = $_FILES['movie-image']['size'];

        // Проверка расширения файла
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Ошибка: Неверный формат файла.");
        }

        // Проверка размера файла
        if ($filesize > 5000000) { // ограничение размера файла, например, 5МБ
            die("Ошибка: Размер файла слишком большой.");
        }

        // Перемещение файла в постоянное хранилище
        $newpath = "images/" . $filename;
        if (!move_uploaded_file($_FILES['movie-image']['tmp_name'], $newpath)) {
            die("Ошибка: не удалось загрузить изображение.");
        }
    }

    // Проверка, было ли загружено изображение
    if ($newpath === null) {
        echo json_encode(['status' => 'error', 'message' => 'Изображение не предоставлено']);
    } else {
        $stmt = $conn->prepare("INSERT INTO movies (Title, Description, Image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $filename);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Фильм успешно добавлен']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при добавлении фильма']);
        }

        $stmt->close();
    }
    $conn->close();
}
?>