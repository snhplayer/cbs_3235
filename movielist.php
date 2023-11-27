<?php
// Параметры подключения к базе данных
$servername = "localhost"; // адрес сервера базы данных
$username = "root";    // имя пользователя базы данных
$password = "";    // пароль
$dbname = "cbs";           // название базы данных

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

// SQL запрос для выбора данных из таблицы movies
$sql = "SELECT MovieID, Title, Description, Image FROM movies";
$result = $conn->query($sql);
$userID=$_COOKIE['user_id'];


?>



<!DOCTYPE html>
<html>
<head>
    <title>Поиск Фильмов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .search-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 800px;
        }

        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .filters {
            margin-bottom: 20px;
        }

        .movie-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .movie {
            width: 48%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .movie img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .movie-details {
            margin-top: 10px;
        }

        .book-button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        .book-button:hover {
            background-color: #004494;
        }

        .movie img {
            max-width: 25%; /* гарантирует, что изображение не будет шире своего контейнера */
            height: auto;    /* сохраняет пропорции изображения */
        }

        .movie-details {
            max-height: 150px; /* ограничивает максимальную высоту блока с описанием */
            overflow: hidden;  /* скрывает лишний текст */
            transition: max-height 0.3s ease; /* плавное изменение высоты */
        }

        .movie-details.expanded {
            max-height: 500px; /* при раскрытии показывает весь текст */
            overflow: visible;
        }

        .details-button {
          background: none;
          border: none;
          color: gray;
          text-decoration: underline;
          font-size: 14px;
        }
    </style>
</head>
<body>
<div class="search-container">
    <input type="text" class="search-bar" placeholder="Введите название фильма...">
    <div class="filters">
        <!-- Фильтры поиска -->
    </div>
    <div class="movie-list">
        <!-- PHP код для отображения фильмов из базы данных -->
        <?php
        if ($result->num_rows > 0) {
            session_start();
            
            // выводим данные каждой строки
            while($row = $result->fetch_assoc()) {
                $movieID = $row["MovieID"]; // MovieID получен из текущего контекста

                // Подготавливаем запрос
                $stmt = $conn->prepare("SELECT SessionID FROM sessions WHERE MovieID = ?");
                $stmt->bind_param("i", $movieID); // 'i' означает 'integer'

                // Выполняем запрос
                $stmt->execute();

                // Получаем результаты
                $result1 = $stmt->get_result();
                if ($result1->num_rows > 0) {
                    // Предполагаем, что у каждого фильма только один сеанс
                    $session = $result1->fetch_assoc();
                    $sessionID = $session['SessionID'];
                } else {
                    // Обработка ситуации, когда сеанс не найден
                    $sessionID = null;
                }
                echo "<div class='movie'>";
                echo "<img src='images/" . $row["Image"] . "' alt='" . $row["Title"] . "'>";
                echo "<div class='movie-details'>";
                echo "<h3>" . $row["Title"] . "</h3>";
                if (strlen($row["Description"]) > 100) {
                    echo "<p>" . (strlen($row["Description"]) > 100 ? substr($row["Description"], 0, 100) : $row["Description"]);
                    echo "<span class='full-description' style='display: none;'>" . substr($row["Description"], 100) . "</span>";
                    echo "<button onclick='toggleDetails(this)' class='details-button'>Подробнее</button>";
                }else{
                    echo "<p>";
                    echo $row["Description"];
                }
                //echo "<button class=\"book-button\">Забронировать Билеты</button>";
                $_SESSION['movieID'] = $movieID;
                $_SESSION['sessionId'] = $sessionID;
                echo "<form action='booking.php' method='post'>";
                echo "<button 'type='submit' class='book-button'>Забронировать Билеты</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";

            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
        <!-- Конец PHP кода -->

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const movieList = document.querySelector('.movie-list');
    movieList.addEventListener('click', function(event) {
        if (event.target && event.target.matches('.details-button')) {
            toggleDetails(event.target);
        }
    });
});

function toggleDetails(button) {
    event.stopPropagation();
    // Находим ближайший родительский элемент класса 'movie'
    var movie = button.closest('.movie');

    // Внутри 'movie' находим элемент 'movie-details'
    var details = movie.querySelector('.movie-details');

    // Внутри 'movie-details' находим элемент 'full-description'
    var fullDescription = details.querySelector('.full-description');

    // Проверяем, найден ли элемент 'full-description'
    if (fullDescription) {
        // Переключаем класс 'expanded' и изменяем стиль отображения 'full-description'
        if (details.classList.contains('expanded')) {
            details.classList.remove('expanded');
            fullDescription.style.display = 'none';
            button.innerText = 'Подробнее';
        } else {
            details.classList.add('expanded');
            fullDescription.style.display = 'inline'; // Или 'inline', в зависимости от нужного стиля
            button.innerText = 'Скрыть';
        }
    } else {
        console.error('Element with class "full-description" not found');
    }
}
</script>
</body>
</html>
