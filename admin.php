<?php
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if(!isset($_COOKIE['user_id'])) {
  
  echo "Зарегистрируйтесь или войдите, чтобы получить доступ к сайту";
  echo "<div class=\"container\">";

  echo "<a href=\"register.php\" class=\"button\">Зарегистрироваться</a>";
  echo "<a href=\"login.php\" class=\"button\">Войти</a>";
  echo "</div>";
  exit();
}

$user_id = $_COOKIE['user_id'];

$query = $conn->prepare("SELECT isAdmin FROM users WHERE UserID = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row["isAdmin"] != 1) {
        
        echo "У вас нет доступа к этой странице.";
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
    <title>Панель Администратора - Управление Сеансами и Фильмами</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">
    <h1>Панель Администратора</h1>


	<div class="form-container">
	    <h2>Добавить Фильм</h2>
	    <form id="add-movie-form" method="post" enctype="multipart/form-data">
	        <div class="form-field">
	            <label for="movie-title">Название Фильма</label>
	            <input type="text" id="movie-title" name="movie-title" required>
	        </div>
	        <div class="form-field">
	            <label for="description">Описание</label>
	            <input type="text" id="description" name="description" required>
	        </div>
	        <div class="form-field">
	            <label for="movie-image">Картинка Фильма</label>
	            <input type="file" id="movie-image" name="movie-image" accept="image/*">
	        </div>
	        <input type="submit" value="Добавить Фильм" class="button">
	    </form>
	</div>


    
    <div class="form-container">
        <h2>Добавить Сеанс</h2>
        <form id="add-session-form" action="/add-session" method="post">
            <div class="form-field">
                <label for="session-movie">Фильм</label>
				<select id="session-movie" name="session-movie">
				    <?php
				    $movies = $conn->query("SELECT * FROM movies");
				    while($movie = $movies->fetch_assoc()) {
				        echo "<option value='".$movie['MovieID']."'>".$movie['Title']."</option>";
				    }
				    ?>
				</select>
            </div>
            <div class="form-field">
                <label for="session-time">Время Сеанса</label>
                <input type="datetime-local" id="session-time" name="session-time" required>
            </div>
            
            <input type="submit" value="Добавить Сеанс" class="button">
        </form>
    </div>

   
    <div class="management-section">
        <h2>Управление Сеансами и Фильмами</h2>
        <?php
        $moviesQuery = $conn->query("SELECT * FROM movies");
        while($movie = $moviesQuery->fetch_assoc()) {
            echo "<div class='movie-item'>";
            echo "<span>".$movie['Title']."</span>"; 
            echo "<button class='button delete-movie' data-movie-id='".$movie['MovieID']."'>Удалить Фильм</button>";
            echo "</div>";
        }
        ?>

        <?php
        $sessionsQuery = $conn->query("SELECT * FROM sessions"); 
        $sessionsQuery = $conn->query("SELECT sessions.SessionID AS session_id, movies.MovieID AS movie_id, movies.Title, sessions.SessionTime FROM sessions JOIN movies ON sessions.MovieID = movies.MovieID");

        while($session = $sessionsQuery->fetch_assoc()) {
            echo "<div class='session-item'>";
            echo "<span>".$session['Title']." - ".$session['SessionTime']."</span>"; 
            echo "<button class='button delete-session' data-session-id='".$session['session_id']."'>Удалить Сеанс</button>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Функция для обновления списка фильмов
    function updateMovieList() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_movies.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var movies = JSON.parse(xhr.responseText);
                var movieSelect = document.getElementById('session-movie');
                movieSelect.innerHTML = '';
                movies.forEach(function(movie) {
                    var option = document.createElement('option');
                    option.value = movie.MovieID;
                    option.textContent = movie.Title;
                    movieSelect.appendChild(option);
                });
            }
        };
        xhr.send();
    }

    // Функция для отправки формы добавления фильма
    document.getElementById('add-movie-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_movie.php", true);
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                location.reload();
            }
        };
        xhr.send(formData);
    });

    // Функция для отправки формы добавления сеанса
    document.getElementById('add-session-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_session.php", true);
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
               location.reload();
            }
        };
        xhr.send(formData);
    });

    // Функция для удаления элементов
    function deleteItem(id, type) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_item.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var elementId = type + '-' + id;
                var element = document.getElementById(elementId);
                if (element) {
                    element.parentNode.removeChild(element);
                }
            }
        };
        xhr.send('id=' + id + '&type=' + type);
    }

    // Обработчики для кнопок удаления
    document.querySelectorAll('.delete-movie').forEach(function(button) {
        button.addEventListener('click', function() {
            var movieId = this.getAttribute('data-movie-id');
            deleteItem(movieId, 'movie');
            location.reload();
        });
    });

    document.querySelectorAll('.delete-session').forEach(function(button) {
        button.addEventListener('click', function() {
            var sessionId = this.getAttribute('data-session-id');
            deleteItem(sessionId, 'session');
            location.reload();
        });
    });

    // Запуск начального обновления списка фильмов
    updateMovieList();
});

</script>
</body>
</html>