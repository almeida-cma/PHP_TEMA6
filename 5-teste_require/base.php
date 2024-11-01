<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exemplo de Require</title>
</head>
<body>
    <h1>Exemplo de Require</h1>
    <?php
    // Incluindo o arquivo arquivo_incluido.php
    require 'arquivo_incluido.php';
    
    // Usando a variável definida no arquivo incluído
    echo "<p>$mensagem</p>";
	echo "<h1>Final script</h1>";
    ?>
</body>
</html>
