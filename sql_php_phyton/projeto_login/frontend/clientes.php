<?php
session_start();

$mensagem = '';
$mensagem_erro = '';

function call_api($method, $url, $data = null, $token = null) {
    $opts = [
        'http' => [
            'method' => $method,
            'header' => "Content-Type: application/json\r\n" . ($token ? "Authorization: Bearer $token\r\n" : ''),
            'ignore_errors' => true
        ]
    ];
    if ($data) {
        $opts['http']['content'] = json_encode($data);
    }
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    $http_response_header = $http_response_header ?? [];
    $status_line = $http_response_header[0] ?? '';
    return [
        'data' => json_decode($result, true),
        'status' => $status_line
    ];
}

function validar_campos($nome, $email, $telefone) {
    $nome = trim($nome);
    $telefone = preg_replace('/\D/', '', $telefone); // Remove não dígitos
    if (mb_strlen($nome) < 10) {
        return 'O nome deve ter no mínimo 10 caracteres.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'O email informado não é válido.';
    }
    if (strlen($telefone) < 11) {
        return 'O telefone deve ter no mínimo 11 dígitos.';
    }
    return '';
}

// Troque para o nome do serviço do backend no Docker Compose
define('API_HOST', 'python_backend');
$api_url = 'http://' . API_HOST . ':8001/clientes';
$token = $_SESSION['token'] ?? null; // Token opcional
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// CRUD Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $erro_validacao = validar_campos($_POST['nome'], $_POST['email'], $_POST['telefone']);
        if ($erro_validacao) {
            $mensagem_erro = $erro_validacao;
        } else {
            $response = call_api('POST', $api_url . '/', [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone']
            ], $token);
            if (strpos($response['status'], '201') !== false || strpos($response['status'], '200') !== false) {
                $mensagem = 'Cliente adicionado com sucesso!';
                header('Location: clientes.php?msg=' . urlencode($mensagem));
                exit;
            } else {
                $mensagem_erro = $response['data']['detail'] ?? 'Erro ao adicionar cliente.';
            }
        }
    } elseif (isset($_POST['edit'])) {
        $erro_validacao = validar_campos($_POST['nome'], $_POST['email'], $_POST['telefone']);
        if ($erro_validacao) {
            $mensagem_erro = $erro_validacao;
        } else {
            call_api('PUT', $api_url . '/' . $_POST['id'], [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone']
            ], $token);
            header('Location: clientes.php');
            exit;
        }
    } elseif (isset($_POST['delete'])) {
        call_api('DELETE', $api_url . '/' . $_POST['id'], null, $token);
        header('Location: clientes.php');
        exit;
    }
}

// Mensagem de sucesso após redirect
if (isset($_GET['msg'])) {
    $mensagem = $_GET['msg'];
}

$response = call_api('GET', $api_url . '/', null, $token);
$clientes = $response['data'];

// Filtra clientes pelo campo de pesquisa
if ($search && is_array($clientes)) {
    $clientes = array_filter($clientes, function($cliente) use ($search) {
        return stripos($cliente['nome'], $search) !== false ||
               stripos($cliente['email'], $search) !== false ||
               stripos($cliente['telefone'] ?? '', $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .clientes-table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        .clientes-table th, .clientes-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .clientes-table th { background: #4e54c8; color: #fff; }
        .clientes-table tr:nth-child(even) { background: #f2f2f2; }
        .form-inline input { margin-right: 8px; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #e53935; color: #fff; }
        .btn-add { background: #4e54c8; color: #fff; margin-bottom: 1rem; }
        .success-message { color: green; margin-bottom: 1rem; }
        .error-message { color: red; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-container" style="max-width:900px;">
        <h2>Clientes</h2>
        <?php if ($mensagem): ?>
            <div class="success-message"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
        <?php if ($mensagem_erro): ?>
            <div class="error-message"><?php echo htmlspecialchars($mensagem_erro); ?></div>
        <?php endif; ?>
        <form method="POST" class="form-inline">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefone" placeholder="Telefone">
            <button type="submit" name="add" class="btn btn-add">Adicionar</button>
        </form>
        <form method="GET" style="margin-bottom: 1rem;">
            <input type="text" name="search" placeholder="Pesquisar clientes..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-add">Pesquisar</button>
            <?php if ($search): ?>
                <a href="clientes.php" class="btn" style="background:#ccc;color:#333;">Limpar</a>
            <?php endif; ?>
        </form>
        <table class="clientes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($clientes)): foreach ($clientes as $cliente): ?>
                <tr>
                    <form method="POST" style="display:inline;">
                        <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                        <td><input type="text" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required></td>
                        <td><input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required></td>
                        <td><input type="text" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>"></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                            <button type="submit" name="edit" class="btn btn-edit">Editar</button>
                            <button type="submit" name="delete" class="btn btn-delete" onclick="return confirm('Deseja excluir este cliente?');">Excluir</button>
                        </td>
                    </form>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <div style="text-align:center;">
            <a href="logout.php" class="logout-btn">Sair</a>
        </div>
    </div>
</body>
</html>
