<?php
$dbHost = 'localhost';
$dbUsername = 'root'; // ваше имя пользователя в базе данных
$dbPassword = ''; // ваш пароль к базе данных
$dbName = 'cbs'; // название вашей базы данных

// Создание подключения к базе данных
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if(!isset($_COOKIE['user_id'])) {
  // показываем кнопки регистрации и авторизации
  echo "Зарегистрируйтесь или войдите, чтобы получить доступ к сайту";
  echo "<div class=\"container\">";

  echo "<a href=\"register.php\" class=\"button\">Зарегистрироваться</a>";
  echo "<a href=\"login.php\" class=\"button\">Войти</a>";
  echo "</div>";
  exit();
}

$user_id = $_COOKIE['user_id'];
// Prepare and execute a query to check if the user is an admin
$query = $conn->prepare("SELECT isAdmin FROM users WHERE UserID = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row["isAdmin"] != 1) {
        // User is not an admin, redirect or show a message
        echo "У вас нет доступа к этой странице.";
        exit();
    }
} else {
    // User not found or some other error
    echo "Произошла ошибка.";
    exit();
}

?>




<!DOCTYPE html>
<html>
<head>
    <title>Панель Администратора - Управление Сеансами и Фильмами</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">
    <h1>Панель Администратора</h1>

    <!-- Форма для добавления фильмов -->
    <div class="form-container">
        <h2>Добавить Фильм</h2>
        <form action="/add-movie" method="post">
            <div class="form-field">
                <label for="movie-title">Название Фильма</label>
                <input type="text" id="movie-title" name="movie-title" required>
            </div>
            <div class="form-field">
                <label for="genre">Описание</label>
                <input type="text" id="description" name="description" required>
            </div>
            <!-- Добавьте другие поля по необходимости -->
            <input type="submit" value="Добавить Фильм" class="button">
        </form>
    </div>

    <!-- Форма для добавления сеансов -->
    <div class="form-container">
        <h2>Добавить Сеанс</h2>
        <form action="/add-session" method="post">
            <div class="form-field">
                <label for="session-movie">Фильм</label>
                <select id="session-movie" name="session-movie">
                    <!-- Здесь должен быть список фильмов -->
                </select>
            </div>
            <div class="form-field">
                <label for="session-time">Время Сеанса</label>
                <input type="datetime-local" id="session-time" name="session-time" required>
            </div>
            <!-- Добавьте другие поля по необходимости -->
            <input type="submit" value="Добавить Сеанс" class="button">
        </form>
    </div>

    <!-- Раздел управления существующими сеансами и фильмами -->
    <div class="management-section">
        <h2>Управление Сеансами и Фильмами</h2>
        <?php
        $moviesQuery = $conn->query("SELECT * FROM movies");
        while($movie = $moviesQuery->fetch_assoc()) {
            echo "<div class='movie-item'>";
            echo "<span>".$movie['Title']."</span>"; // замените 'movie_name' на имя вашего столбца
            echo "<button class='button delete-movie' data-movie-id='".$movie['MovieID']."'>Удалить Фильм</button>";
            echo "</div>";
        }
        ?>

        <?php
        $sessionsQuery = $conn->query("SELECT * FROM sessions"); // замените 'sessions' на имя вашей таблицы сеансов
        $sessionsQuery = $conn->query("SELECT sessions.SessionID AS session_id, movies.MovieID AS movie_id, movies.Title, sessions.SessionTime FROM sessions JOIN movies ON sessions.MovieID = movies.MovieID");

        while($session = $sessionsQuery->fetch_assoc()) {
            echo "<div class='session-item'>";
            echo "<span>".$session['Title']." - ".$session['SessionTime']."</span>"; // Отображение названия фильма и времени сеанса
            echo "<button class='button delete-session' data-session-id='".$session['session_id']."'>Удалить Сеанс</button>";
            echo "</div>";
        }
        ?>
    </div>
</div>

</body>
</html>
