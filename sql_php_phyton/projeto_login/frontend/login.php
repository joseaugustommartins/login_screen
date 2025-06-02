<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #ccffcc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #2e7d32;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 1rem;
        }
        @media (max-width: 600px) {
            .login-box {
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <form method="POST" action="login_handler.php">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="error">Usuário ou senha incorretos!</div>';
            }
            ?>
        </form>
    </div>
</body>
</html>
