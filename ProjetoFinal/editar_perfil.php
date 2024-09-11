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

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $imagem = $_POST['imagem']; // Assumindo que a URL da imagem é fornecida como texto
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];

    // Verifica a senha atual
    $sql = "SELECT senha FROM pessoa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($senha_atual, $user['senha'])) {
        // Se a senha atual estiver correta, atualiza o nome, email e imagem

        $sql_update = "UPDATE pessoa SET nome = ?, email = ?, imagem = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $nome, $email, $imagem, $user_id);
        $stmt_update->execute();

        // Se o usuário inseriu uma nova senha, atualiza também a senha
        if (!empty($nova_senha)) {
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sql_update_senha = "UPDATE pessoa SET senha = ? WHERE id = ?";
            $stmt_update_senha = $conn->prepare($sql_update_senha);
            $stmt_update_senha->bind_param("si", $nova_senha_hash, $user_id);
            $stmt_update_senha->execute();
        }

        echo "Perfil atualizado com sucesso.";
    } else {
        // Se a senha atual estiver incorreta, exibe uma mensagem de erro
        echo "Erro: A senha atual está incorreta.";
    }

    $stmt->close();
}

// Consulta para obter os dados do usuário
$sql = "SELECT nome, email, imagem FROM pessoa WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="style/style_editar_perfil.css">
</head>
<body>
    <header>
        <h1>Editar Perfil</h1>
    </header>
    <main>
        <div class="profile-container">
        <form method="POST" action="editar_perfil.php">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    
    <label for="imagem">URL da Imagem:</label>
    <input type="text" id="imagem" name="imagem" value="<?php echo htmlspecialchars($user['imagem']); ?>">

    <label for="senha_atual">Senha Atual:</label>
    <input type="password" id="senha_atual" name="senha_atual" required>

    <label for="nova_senha">Nova Senha (opcional):</label>
    <input type="password" id="nova_senha" name="nova_senha">

    <button type="submit">Atualizar Perfil</button>
</form>
<button type="button" onclick="window.location.replace('perfil.php')" class="back-button">Voltar</button>
        </div>
    </main>
</body>
</html>
