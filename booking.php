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

// Данные сеанса
session_start();

$sessionId = $_SESSION['sessionId'];
$user_id = $_COOKIE['user_id'];
// Получение занятых мест   
$sql = "SELECT RowNumber, SeatNumber 
        FROM bookings 
        WHERE SessionID = $sessionId";
        
$result = mysqli_query($conn, $sql);

$occupied = [];
while ($row = mysqli_fetch_assoc($result)) {
  $key = $row['RowNumber'] . '_' . $row['SeatNumber'];
  $occupied[$key] = $row; 
}

echo "<script>";
echo "var sessionID = " . json_encode($sessionId) . ";";
echo "var userID = " . json_encode($user_id) . ";";
echo "</script>";


?>




<!DOCTYPE html>
<html>
<head>
    <title>Выбор Сидений</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .seating-chart {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 600px;
            text-align: center;
        }
        .account-section {
            margin-bottom: 20px;
        }

        .account-section label {
            display: block;
            margin-bottom: 5px;
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

        h2 {
            color: #333;
        }

        .row {
            margin: 10px 0;
        }

        .seat {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin: 3px;
            border-radius: 50%;
            background-color: #0056b3; /* Синий цвет для свободных мест */
        }

        .seat.occupied {
            background-color: grey;
        }

        .seat:not(.occupied):hover {
            cursor: pointer;
            background-color: lightblue;
        }

        .footer {
            margin-top: 20px;
        }

        .footer button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .footer button:hover {
            background-color: #004494;
        }

        .seat.selected {
    background-color: #ffdd57; /* желтый цвет для выделенных мест */
        }


    </style>
</head>
<body>
<div class="seating-chart">

  <h2>Выбор сидений</h2>
  
    <?php  
    for($i=1; $i<=5; $i++) {
        echo '<div class="row">';
        for($j=1; $j<=10; $j++) {

            $key = $i . '_' . $j;
                
            if(isset($occupied[$key])) {
                
              $row = $occupied[$key]['RowNumber'];
              $seat = $occupied[$key]['SeatNumber'];
                
              $class = "occupied";
                
            } else {
                
              $class = "";
                
            }

    echo '<div class="seat '. $class.'" data-row="' . $i . '" data-seat="' . $j . '"></div>';

  }

}
    ?>

  <div class="footer">
    <div>
    <button id="bookButton">Забронировать выбранные места</button>
    <form action="userpanel.php" method="post">
    <button type="submit">Завершить бронирование</button>
    </form>
</div>
  </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    var selectedRow, selectedSeat;

    // Обработчик клика по месту
    $('.seat').on('click', function() {
        $('.seat').removeClass('selected'); // Снимаем выделение с других мест
        $(this).addClass('selected'); // Выделяем выбранное место
        selectedRow = $(this).data('row');
        selectedSeat = $(this).data('seat');
    });

    $('#bookButton').on('click', function() {
        // Проверка, выбрано ли место
        if (!selectedRow || !selectedSeat) {
            alert('Пожалуйста, выберите место');
            return;
        }

        var user_id = 31;
        var bookingTime = new Date().toISOString(); // Текущее время
        var sqlQuery = `INSERT INTO \`bookings\`(\`SessionID\`, \`UserID\`, \`RowNumber\`, \`SeatNumber\`, \`BookingTime\`) VALUES ('${sessionID}', '${userID}', '${selectedRow}', '${selectedSeat}', '${bookingTime}')`;
        console.log("SQL-запрос: ", sqlQuery);
        $.ajax({
            type: "POST",
            url: "book.php", // Укажите путь к вашему PHP-скрипту
            data: {
                row: selectedRow,
                seat: selectedSeat,
                sessionId: sessionID,
                user_id: userID,
                bookingTime: bookingTime,
            },
            success: function(response) {
                console.log(response);
                $('.seat[data-row="' + selectedRow + '"][data-seat="' + selectedSeat + '"]').addClass('occupied').removeClass('selected');
            },
            error: function() {
                alert('Ошибка бронирования');
            }
        });
    });
});

</script>


</body>
</html>
