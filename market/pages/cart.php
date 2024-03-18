<?php
include_once '../templates/header.php';
session_start();

// Verifica se existe um carrinho na sessão
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Adiciona o produto ao carrinho quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Verifica se o produto já está no carrinho
    if (isset($_SESSION['cart'][$product_id])) {
        // Se o produto já estiver no carrinho, apenas atualize a quantidade
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Se o produto não estiver no carrinho, adicione-o com a quantidade especificada
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity
        ];
    }
}

echo "<h2>Carrinho de Compras</h2>";

// Botão para limpar o carrinho
echo "<form action='' method='post'>";
echo "<input type='hidden' name='clear_cart' value='true'>";
echo "<button type='submit'>Limpar Carrinho</button>";
echo "</form>";

// Verifica se o botão "Limpar Carrinho" foi acionado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    // Remove todos os itens do carrinho
    $_SESSION['cart'] = [];
    // Recarrega a página para refletir as mudanças
    header('Location: cart.php');
    exit();
}

// Verifica se o carrinho está vazio
if (empty($_SESSION['cart'])) {
    echo "<p>O carrinho está vazio.</p>";
} else {
    // Inicializa variáveis para o total de itens e o total geral da compra
    $total_items = 0;
    $total_price = 0;

    echo "<ul>";
    foreach ($_SESSION['cart'] as $product_id => $product) {
        // Certifica-se de que $product é um array antes de acessar seus elementos
        if (is_array($product) && array_key_exists('name', $product) && array_key_exists('price', $product) && array_key_exists('quantity', $product)) {
            // Calcula o subtotal do produto
            $subtotal = $product['price'] * $product['quantity'];

            // Exibe os detalhes do produto
            echo "<li>{$product['name']} - R$ {$product['price']} x {$product['quantity']} = R$ $subtotal</li>";

            // Adiciona a quantidade de itens e o subtotal ao total geral da compra
            $total_items += $product['quantity'];
            $total_price += $subtotal;
        }
    }
    echo "</ul>";

    // Exibe o total de itens e o total geral da compra
    echo "<p>Total de Itens: $total_items</p>";
    echo "<p>Total: R$ $total_price</p>";
}

include_once '../templates/footer.php';
?>
