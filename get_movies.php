<?php
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'cbs'; 
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$query = $conn->query("SELECT * FROM movies");

$movies = array();

while($movie = $query->fetch_assoc()) {

  $movieId = $movie['MovieID'];

  $sql = "SELECT COUNT(*) AS session_count 
          FROM sessions  
          WHERE MovieID=?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $movieId);
  $stmt->execute();
  
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  
  $movie['session_count'] = $row['session_count'];
  
  $movies[] = $movie;
}

echo json_encode($movies);
?>