<?php include_once '../templates/header.php'; ?>

<div class="product-detail">
    <?php
    include_once '../includes/db_connection.php';

    // Verifica se o parâmetro de ID do produto foi fornecido na URL
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];

        try {
            // Consulta para selecionar o produto com base no ID fornecido
            $sql = "SELECT * FROM produtos WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $product_id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o produto foi encontrado
            if ($product) {
                // Exibe as informações do produto
                echo "<h2>{$product['produto']}</h2>";
                echo "<img src='../uploads/{$product['imagem']}' alt='{$product['produto']}'>";
                echo "<p>R$ {$product['valor']}</p>";
                echo "<form action='../pages/cart.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='{$product['id']}'>";
                echo "<input type='hidden' name='product_name' value='{$product['produto']}'>"; // Corrigindo este campo oculto
                echo "<input type='hidden' name='product_price' value='{$product['valor']}'>"; // Corrigindo este campo oculto
                echo "<label for='quantity'>Quantidade:</label>";
                echo "<input type='number' id='quantity' name='quantity' value='1' min='1'>";
                echo "<button type='submit'>Adicionar ao Carrinho</button>";
                echo "</form>";
            } else {
                echo "Produto não encontrado.";
            }
        } catch(PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }
    } else {
        echo "ID do produto não fornecido.";
    }
    ?>
</div>

<?php include_once '../templates/footer.php'; ?>
