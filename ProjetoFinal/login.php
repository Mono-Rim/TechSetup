<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/style_registro.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();
        include 'db.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $stmt = $pdo->prepare('SELECT * FROM pessoa WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                echo '<div class="message">Login bem-sucedido!</div>';
                header('Location: index.php');
                ?>
                
                <?php
            } else {
                echo '<div class="message">Email ou senha incorretos!</div>';
                ?>
                <a href="tela_login.html">Voltar</a>
                <?php
            }
        }
        ?>
        
    </div>
    <script src="scripts/script_login.js"></script>
</body>
</html>
