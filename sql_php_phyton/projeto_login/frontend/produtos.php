<?php
session_start();

define('API_HOST', 'python_backend');
$api_url = 'http://' . API_HOST . ':8001/produtos';
$token = $_SESSION['token'] ?? null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $response = call_api('POST', $api_url . '/', [
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao'],
            'marca' => $_POST['marca'],
            'valor' => floatval($_POST['valor'])
        ], $token);
        if (strpos($response['status'], '201') !== false || strpos($response['status'], '200') !== false) {
            $mensagem = 'Produto adicionado com sucesso!';
            header('Location: produtos.php?msg=' . urlencode($mensagem));
            exit;
        } else {
            $mensagem_erro = $response['data']['detail'] ?? 'Erro ao adicionar produto.';
        }
    } elseif (isset($_POST['edit'])) {
        call_api('PUT', $api_url . '/' . $_POST['id'], [
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao'],
            'marca' => $_POST['marca'],
            'valor' => floatval($_POST['valor'])
        ], $token);
        header('Location: produtos.php');
        exit;
    } elseif (isset($_POST['delete'])) {
        call_api('DELETE', $api_url . '/' . $_POST['id'], null, $token);
        header('Location: produtos.php');
        exit;
    }
}

if (isset($_GET['msg'])) {
    $mensagem = $_GET['msg'];
}

$response = call_api('GET', $api_url . '/', null, $token);
$produtos = $response['data'];

if ($search && is_array($produtos)) {
    $produtos = array_filter($produtos, function($produto) use ($search) {
        return stripos($produto['nome'], $search) !== false ||
               stripos($produto['descricao'] ?? '', $search) !== false ||
               stripos($produto['marca'] ?? '', $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .produtos-table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        .produtos-table th, .produtos-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .produtos-table th { background: #4e54c8; color: #fff; }
        .produtos-table tr:nth-child(even) { background: #f2f2f2; }
        .form-inline input { margin-right: 8px; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #e53935; color: #fff; }
        .btn-add { background: #4e54c8; color: #fff; margin-bottom: 1rem; }
        .success-message { color: green; margin-bottom: 1rem; }
        .error-message { color: red; margin-bottom: 1rem; }
        @media (max-width: 900px) {
            .login-container { padding: 10px; }
            .produtos-table, .produtos-table thead, .produtos-table tbody, .produtos-table th, .produtos-table td, .produtos-table tr {
                display: block;
                width: 100%;
            }
            .produtos-table thead { display: none; }
            .produtos-table tr { margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 8px; background: #fff; box-shadow: 0 2px 6px #0001; }
            .produtos-table td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                min-height: 40px;
            }
            .produtos-table td:before {
                position: absolute;
                top: 8px;
                left: 8px;
                width: 45%;
                white-space: nowrap;
                font-weight: bold;
                color: #4e54c8;
            }
            .produtos-table td:nth-child(1):before { content: 'ID'; }
            .produtos-table td:nth-child(2):before { content: 'Nome'; }
            .produtos-table td:nth-child(3):before { content: 'Descrição'; }
            .produtos-table td:nth-child(4):before { content: 'Marca'; }
            .produtos-table td:nth-child(5):before { content: 'Valor'; }
            .produtos-table td:nth-child(6):before { content: 'Ações'; }
            .form-inline { flex-direction: column; }
            .form-inline input, .form-inline button { width: 100%; margin: 4px 0; }
        }
    </style>
</head>
<body>
    <div class="login-container" style="max-width:1000px;">
        <h2>Produtos</h2>
        <?php if ($mensagem): ?>
            <div class="success-message"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
        <?php if ($mensagem_erro): ?>
            <div class="error-message"><?php echo htmlspecialchars($mensagem_erro); ?></div>
        <?php endif; ?>
        <form method="POST" class="form-inline">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="descricao" placeholder="Descrição">
            <input type="text" name="marca" placeholder="Marca">
            <input type="number" step="0.01" name="valor" placeholder="Valor" required>
            <button type="submit" name="add" class="btn btn-add">Adicionar</button>
        </form>
        <form method="GET" style="margin-bottom: 1rem;">
            <input type="text" name="search" placeholder="Pesquisar produtos..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-add">Pesquisar</button>
            <?php if ($search): ?>
                <a href="produtos.php" class="btn" style="background:#ccc;color:#333;">Limpar</a>
            <?php endif; ?>
        </form>
        <table class="produtos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Marca</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($produtos)): foreach ($produtos as $produto): ?>
                <tr>
                    <form method="POST" style="display:inline;">
                        <td><?php echo htmlspecialchars($produto['id']); ?></td>
                        <td><input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required></td>
                        <td><input type="text" name="descricao" value="<?php echo htmlspecialchars($produto['descricao'] ?? ''); ?>"></td>
                        <td><input type="text" name="marca" value="<?php echo htmlspecialchars($produto['marca'] ?? ''); ?>"></td>
                        <td><input type="number" step="0.01" name="valor" value="<?php echo htmlspecialchars($produto['valor']); ?>" required></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                            <button type="submit" name="edit" class="btn btn-edit">Editar</button>
                            <button type="submit" name="delete" class="btn btn-delete" onclick="return confirm('Deseja excluir este produto?');">Excluir</button>
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
