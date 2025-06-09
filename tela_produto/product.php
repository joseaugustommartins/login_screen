<?php include 'get_product.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?php echo $produto['nome']; ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="product-container">
    <h1><?php echo $produto['nome']; ?></h1>
    <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
    <p><?php echo $produto['descricao']; ?></p>
    <button onclick="alert('Produto adicionado ao carrinho!')">Adicionar ao Carrinho</button>
  </div>
</body>
</html>
