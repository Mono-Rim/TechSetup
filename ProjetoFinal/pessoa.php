<?php
include 'db.php';

$stmt = $pdo->query('SELECT * FROM pessoa');
$pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($pessoas);
?>
