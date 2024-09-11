<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Produto - Tech Setup</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: tela_login.html');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'loja_pc');

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o ID do usuário logado e do produto
$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Lógica para finalizar a compra
    // Aqui você pode adicionar o produto ao pedido e finalizar o pagamento
    // Exemplo de mensagem de sucesso (substitua com a lógica real de finalização)
    echo "<p>Compra finalizada com sucesso!</p>";
    echo "<a href='index.php'>Voltar à Página Principal</a>";
} else {
    echo "<p>Produto inválido.</p>";
    echo "<a href='index.php'>Voltar à Página Principal</a>";
}

$conn->close();
?>
</body>
</html>
