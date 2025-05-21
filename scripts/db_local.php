<?php
// connection à la BDD SQL
$host = 'localhost';
$user = 'root';
$pass = ''; 
$db = 'esportify'; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur MySQL : " . $conn->connect_error);
}
?>