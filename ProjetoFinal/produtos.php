<?php
include 'db.php';

$stmt = $pdo->query('SELECT * FROM produtos');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produtos);
?>
