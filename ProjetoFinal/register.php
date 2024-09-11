<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style/style_registro.css">
</head>
<body>
    <div class="container">
        <?php
        include 'db.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            $stmt = $pdo->prepare('INSERT INTO pessoa (nome, email, senha) VALUES (?, ?, ?)');
            if ($stmt->execute([$nome, $email, $senha])) {
                echo '<div class="message">Cadastro realizado com sucesso!</div>';
            } else {
                echo '<div class="message">Erro ao realizar cadastro!</div>';
            }
        }
        ?>
        <a href="tela_login.html">Voltar</a>
    </div>
</body>
</html>
