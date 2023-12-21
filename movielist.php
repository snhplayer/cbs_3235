<?php

$servername = "localhost"; 
$username = "root";    
$password = "";    
$dbname = "cbs";          


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!isset($_COOKIE['user_id'])) {

 
  echo "Зарегистрируйтесь или войдите, чтобы получить доступ к сайту";
  echo "<div class=\"container\">";
  echo "<a href=\"register.php\" class=\"button\">Зарегистрироваться</a>";
  echo "<a href=\"login.php\" class=\"button\">Войти</a>";
  echo "</div>";
  exit();
}


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
            max-width: 25%; 
            height: auto;    
        }

        .movie-details {
            max-height: 150px; 
            overflow: hidden;  
            transition: max-height 0.3s ease; 
        }

        .movie-details.expanded {
            max-height: 500px; 
            overflow: visible;
        }

        .details-button {
          background: none;
          border: none;
          color: gray;
          text-decoration: underline;
          font-size: 14px;
        }

        .userpanel button {
    background-color: #0056b3;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    
}
    </style>
</head>
<body>

<div class="search-container">
    <h2>Список фильмов</h2>
    <div class="filters">
            <div class="userpanel">
    <button type="button" class="personal-cabinet-button" onclick="location.href='userpanel.php'">Личный кабинет</button>
    </div>
    </div>
    <div class="movie-list">
        
        <?php
        if ($result->num_rows > 0) {
            session_start();
            
            
            while($row = $result->fetch_assoc()) {
                $movieID = $row["MovieID"]; // MovieID получен из текущего контекста

                
                $stmt = $conn->prepare("SELECT SessionID FROM sessions WHERE MovieID = ?");
                $stmt->bind_param("i", $movieID); // 'i' означает 'integer'

                
                $stmt->execute();

                
                $result1 = $stmt->get_result();
                if ($result1->num_rows > 0) {
                    
                    $session = $result1->fetch_assoc();
                    $sessionID = $session['SessionID'];
                } else {
                    
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
                
                $_SESSION['movieID'] = $movieID;
                $_SESSION['sessionId'] = $sessionID;
                       if ($sessionID != null) {
                       echo "<form action='booking.php' method='post'>";
                       echo "<button type='submit' class='book-button'>Забронировать Билеты</button>";
                       echo "</form>";
                   } else {
                       echo "<button class='book-button' disabled>Забронировать Билеты (Недоступно)</button>";
                   }
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
    
    var movie = button.closest('.movie');

    
    var details = movie.querySelector('.movie-details');

    
    var fullDescription = details.querySelector('.full-description');

    
    if (fullDescription) {
       
        if (details.classList.contains('expanded')) {
            details.classList.remove('expanded');
            fullDescription.style.display = 'none';
            button.innerText = 'Подробнее';
        } else {
            details.classList.add('expanded');
            fullDescription.style.display = 'inline'; 
            button.innerText = 'Скрыть';
        }
    } else {
        console.error('Element with class "full-description" not found');
    }
}
</script>
</body>
</html>
