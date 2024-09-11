<?php
include 'db.php';

$stmt = $pdo->query('SELECT * FROM carrinho_compras');
$carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($carrinho);
?>
