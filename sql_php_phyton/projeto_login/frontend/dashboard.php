<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
            padding: 20px;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .welcome-message {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #4e54c8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #3a3f9e;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="welcome-message">Bem-vindo(a), <?php echo htmlspecialchars($username); ?>!</h1>
        <div style="text-align: center;">
            <a href="logout.php" class="logout-btn">Sair</a>
        </div>
    </div>
</body>
</html>
