<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Quiz</title>
</head>
<body>
    <?php
    // Verifica se o nome e as respostas foram enviadas via formulário
    if(isset($_POST['nome']) && isset($_POST['resposta1']) && isset($_POST['resposta2']) && isset($_POST['resposta3'])) {
        $nome = $_POST['nome'];
        $resposta1 = strtolower($_POST['resposta1']);
        $resposta2 = strtolower($_POST['resposta2']);
        $resposta3 = strtolower($_POST['resposta3']);

        // Verifica as respostas
        $acertos = 0;
        if($resposta1 == "brasília") {
            $acertos++;
        }
        if($resposta2 == "cervantes") {
            $acertos++;
        }
        if($resposta3 == "oito") {
            $acertos++;
        }

        // Exibe o resultado
        echo "<h2>Resultado do Quiz</h2>";
        echo "<p>Olá, $nome!</p>";
        echo "<p>Você acertou $acertos de 3 perguntas.</p>";

        // Botão para resetar
        echo '<form action="index.php" method="post">';
        echo '<button type="submit">Resetar Quiz</button>';
        echo '</form>';
    } else {
        // Se as respostas não foram enviadas, redireciona para a página inicial
        header("Location: index.php");
        exit();
    }
    ?>
</body>
</html>
