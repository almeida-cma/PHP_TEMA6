<?php
// Configuração do banco de dados
$servername = "localhost";
$port = 7306;
$username = "root";
$password = "";
$dbname = "banco_de_dados";

try {
    // Conexão com o banco de dados
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
