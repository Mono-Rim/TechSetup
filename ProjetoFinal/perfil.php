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
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="style/style_perfil.css">
</head>
<body>
    <header>
        <h1>Perfil do Usuário</h1>
    </header>
    <main>
        <div class="profile-container">
            <h2>Bem-vindo, <?php echo htmlspecialchars($user['nome']); ?></h2>
            <img src="<?php echo htmlspecialchars($user['imagem']); ?>" alt="Imagem do Perfil" style="width: 150px; height: 150px; border-radius: 50%;">
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <div class="butons">
                <a href="index.php" class="btn">Voltar ao Início</a>
                <a href="editar_perfil.php" class="btn">Editar Perfil</a>
            </div>

        </div>
    </main>
</body>
</html>
