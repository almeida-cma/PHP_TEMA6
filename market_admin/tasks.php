<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se o usuário não estiver logado, redireciona para a página de login
    header('Location: admin.php');
    exit;
}

$servername = "localhost";
$port = 7306;
$username = "root";
$password = "";
$dbname = "banco_de_dados";

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}

function displayProdutos($conn) {
    $sql = "SELECT * FROM produtos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<table>";
    echo "<tr><th>ID</th><th>Produto</th><th>Valor</th><th>Imagem</th><th>Ações</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['produto']}</td>";
        echo "<td>{$row['valor']}</td>";
        echo "<td><img src='uploads/{$row['imagem']}' style='width:100px;height:100px;'></td>";
        echo "<td>";
        echo "<button style='margin-right: 5px;' onclick='openModal(\"{$row['id']}\", \"{$row['produto']}\", \"{$row['valor']}\", \"{$row['imagem']}\")'>Editar</button>";
        echo "<form method='post' action='admin.php'>";
        echo "<input type='hidden' name='delete_id' value='{$row['id']}'>";
        echo "<button type='submit' name='delete'>Excluir</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function addProduto($conn, $produto, $valor, $imagem) {
    $sql = "INSERT INTO produtos (produto, valor, imagem) VALUES (:produto, :valor, :imagem)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':produto', $produto);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':imagem', $imagem);
    $stmt->execute();
}

function updateProduto($conn, $id, $produto, $valor, $imagem, $imagem_temp) {
    // Verifica se uma nova imagem foi fornecida
    if (!empty($imagem_temp)) {
        // Se uma nova imagem foi fornecida, move e atualiza o registro com a nova imagem
        move_uploaded_file($imagem_temp, "uploads/$imagem");
        $sql = "UPDATE produtos SET produto = :produto, valor = :valor, imagem = :imagem WHERE id = :id";
    } else {
        // Se nenhuma nova imagem foi fornecida, mantém a imagem existente no banco de dados
        $sql = "UPDATE produtos SET produto = :produto, valor = :valor WHERE id = :id";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':produto', $produto);
    $stmt->bindParam(':valor', $valor);
    // Se nenhuma nova imagem foi fornecida, vincula a imagem existente
    if (!empty($imagem_temp)) {
        $stmt->bindParam(':imagem', $imagem);
    }
    $stmt->execute();
}

function deleteProduto($conn, $id) {
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $produto = $_POST['produto'];
    $valor = $_POST['valor'];
    $imagem = $_FILES['imagem']['name'];
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    move_uploaded_file($imagem_temp, "uploads/$imagem");
    addProduto($conn, $produto, $valor, $imagem);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['produto_id'];
    $produto = $_POST['produto'];
    $valor = $_POST['valor'];
    $imagem = $_FILES['imagem']['name'];
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    updateProduto($conn, $id, $produto, $valor, $imagem, $imagem_temp);
    header("Location: admin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    deleteProduto($conn, $id);
    header("Location: admin.php");
}

displayProdutos($conn);

$conn = null;
?>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Editar Produto</h3>
        <form method="post" action="admin.php" enctype="multipart/form-data">
            <input type="hidden" id="edit_produto_id" name="produto_id">
            <input type="text" id="edit_produto" name="produto" placeholder="Produto" required>
            <input type="number" id="edit_valor" name="valor" placeholder="Valor" step="0.01" required>
            <input type="file" id="edit_imagem" name="imagem" accept="image/*">
            <button type="submit" name="update">Atualizar</button>
        </form>
    </div>
</div>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <input type="text" name="produto" placeholder="Produto" required>
    <input type="number" name="valor" placeholder="Valor" step="0.01" required>
    <input type="file" name="imagem" accept="image/*" required>
    <button type="submit" name="add">Adicionar</button>
</form>

<div class="logout-container">
    <a href="logout.php" class="logout">Sair</a>
</div>

<script>
    function openModal(id, produto, valor, imagem) {
        document.getElementById('edit_produto_id').value = id;
        document.getElementById('edit_produto').value = produto;
        document.getElementById('edit_valor').value = valor;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
