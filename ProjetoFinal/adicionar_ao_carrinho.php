<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: tela_login.html');
    exit();
}

// Conecta ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'loja_pc');

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Obtém o ID do produto a ser adicionado ao carrinho
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Verifica se o item já está no carrinho
    $sql = "SELECT * FROM carrinho_compras WHERE id_pessoa = ? AND id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Item já está no carrinho, pode atualizar a quantidade se necessário
        echo "<script>alert('Item já está no carrinho.'); window.location.href = 'index.php';</script>";
    } else {
        // Adiciona o item ao carrinho
        $sql = "INSERT INTO carrinho_compras (id_pessoa, id_produto, quantidade) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);

        if ($stmt->execute()) {
            echo "<script>alert('Item adicionado ao carrinho com sucesso!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Erro ao adicionar o item ao carrinho.'); window.location.href = 'index.php';</script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>
