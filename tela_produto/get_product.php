<?php
include 'db.php';

$id = $_GET['id'] ?? 1;

$sql = "SELECT * FROM produtos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $produto = $result->fetch_assoc();
} else {
  echo "Produto não encontrado.";
  exit;
}
?>
