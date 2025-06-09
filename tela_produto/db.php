<?php
$host = "localhost";
$user = "admin";
$password = "admin123";
$database = "seu_banco";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}
?>
