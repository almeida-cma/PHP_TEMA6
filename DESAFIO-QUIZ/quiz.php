<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
</head>
<body>
    <?php
    // Verifica se o nome foi enviado via formulário
    if(isset($_POST['nome'])) {
        $nome = $_POST['nome'];
    } else {
        // Se o nome não foi enviado, redireciona de volta para a página inicial
        header("Location: index.php");
        exit();
    }
    ?>

    <h2>Olá, <?php echo $nome; ?>, responda às seguintes perguntas:</h2>

    <form action="resultado.php" method="post">
        <input type="hidden" name="nome" value="<?php echo $nome; ?>">
        
        <p>Pergunta 1: Qual é a capital do Brasil?</p>
        <input type="text" name="resposta1" required><br>

        <p>Pergunta 2: Quem escreveu Dom Quixote?</p>
        <input type="text" name="resposta2" required><br>

        <p>Pergunta 3: Quantos planetas existem no sistema solar?</p>
        <input type="text" name="resposta3" required><br>

        <button type="submit">Verificar Respostas</button>
    </form>
</body>
</html>
