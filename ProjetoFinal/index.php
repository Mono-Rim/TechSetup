<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Setup</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para a página de login se não estiver logado
    header('Location: tela_login.html');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'loja_pc');

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT imagem FROM pessoa WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $imagem_perfil = $user['imagem'];
    if (!$imagem_perfil) {
        $imagem_perfil = 'https://i.imgur.com/s1ZdeUF.jpg';
    }
}

$stmt->close();
$conn->close();
?>
    <header>
        <h1>Tech Setup</h1>
        <div id="perfil">
            <a href="perfil.php" class="profile-icon">
                <img src="<?php echo htmlspecialchars($imagem_perfil); ?>" alt="Perfil">
            </a>
            <a href="logout.php">Sair</a>
        </div>
    </header>
    <main>
        <form method="GET" action="">
            <label for="categoria">Filtrar por Categoria:</label>
            <select name="categoria" id="categoria" onchange="this.form.submit()">
                <option value="">Filtrar</option>
                <option value="Monitores">Monitores</option>
                <option value="Processadores">Processadores</option>
                <option value="Placas de Vídeo">Placas de Vídeo</option>
                <option value="Memórias RAM">Memória RAM</option>
                <option value="">Todos</option>
            </select>
        </form>
        <div id="produtos">
            <?php
            // Conexão com o banco de dados
            $conn = new mysqli('localhost', 'root', '', 'loja_pc');

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Verifica se uma categoria foi selecionada
            $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

            // Consulta SQL para buscar os produtos
            if ($categoria) {
                $sql = "SELECT id, nome, descricao, preco, estoque, categoria, imagem FROM produtos WHERE categoria = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $categoria);
            } else {
                $sql = "SELECT id, nome, descricao, preco, estoque, categoria, imagem FROM produtos";
                $stmt = $conn->prepare($sql);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='produto'>";
                    echo "<img src='" . $row['imagem'] . "' alt='" . $row['nome'] . "'>";
                    echo "<h2>" . $row['nome'] . "</h2>";
                    echo "<p>" . $row['descricao'] . "</p>";
                    echo "<p>Preço: R$ " . $row['preco'] . "</p>";
                    echo "<p>Estoque: " . $row['estoque'] . "</p>";
                    echo "<p>Categoria: " . $row['categoria'] . "</p>";
                    
                    // Botões "Adicionar ao Carrinho" e "Comprar"
                    echo "<div class='botoes-produto'>";
                    echo "<a href='adicionar_ao_carrinho.php?id=" . $row['id'] . "' class='add-to-cart'>Adicionar ao Carrinho</a>";
                    echo "<a href='comprar_produto.php?id=" . $row['id'] . "' class='comprar'>Comprar</a>";
                    echo "</div>";
                    
                    echo "</div>";
                }
            } else {
                echo "Nenhum produto encontrado.";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>© 2024 Tech Setup. Todos os direitos reservados.</p>
    </footer>
    <script src="script/script.js"></script>
</body>
</html>
