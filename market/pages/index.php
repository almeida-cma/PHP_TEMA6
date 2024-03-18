<?php include_once '../templates/header.php'; ?>

<h2>Produtos Disponíveis</h2>

<div class="container">
    <?php
    include_once '../includes/db_connection.php';

    try {
        // Seleciona todos os produtos da tabela 'produtos'
        $sql = "SELECT * FROM produtos";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Exibe os produtos em um loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='produto'>";
            echo "<img src='../uploads/{$row['imagem']}' alt='{$row['produto']}'>";
            echo "<h3>{$row['produto']}</h3>";
            echo "<a href='../pages/product_detail.php?id={$row['id']}'>Detalhes</a>";
            echo "</div>";
        }
    } catch(PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
    ?>
</div>

<?php include_once '../templates/footer.php'; ?>
