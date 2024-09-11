<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $imagem = $_FILES['imagem'];

    // Verifica se o upload foi bem-sucedido
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid() . '.' . $extensao;
        $caminhoImagem = 'uploads/' . $nomeImagem;

        // Move a imagem para o diretório de uploads
        if (move_uploaded_file($imagem['tmp_name'], $caminhoImagem)) {
            // Insere os dados no banco de dados
            $stmt = $pdo->prepare('INSERT INTO pessoa (nome, email, imagem) VALUES (?, ?, ?)');
            $stmt->execute([$nome, $email, $caminhoImagem]);

            echo 'Perfil atualizado com sucesso!';
        } else {
            echo 'Erro ao mover a imagem para o diretório de uploads.';
        }
    } else {
        echo 'Erro no upload da imagem.';
    }
}
?>
