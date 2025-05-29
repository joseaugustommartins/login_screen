<?php
session_start();

// Verifica se o token de autenticação está presente
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Seja bem-vindo!</h1>
</body>
</html>
