<?php
require_once "conexao.php";

$erro = "";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"]) || (int) $_GET["id"] < 1) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT id, titulo, genero, preco
        FROM jogos
        WHERE id = :id";

$consulta = $conexao->prepare($sql);
$consulta->execute([":id" => $id]);

$jogo = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$jogo) {
    header("Location: index.php");
    exit;
}

$titulo = $jogo["titulo"];
$genero = $jogo["genero"];
$preco = $jogo["preco"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = trim($_POST["titulo"] ?? "");
    $genero = trim($_POST["genero"] ?? "");
    $precoDigitado = trim($_POST["preco"] ?? "");

    if (
        $titulo === "" ||
        $genero === "" ||
        $precoDigitado === ""
    ) {
        $erro = "Preencha todos os campos.";

    } elseif (!is_numeric($precoDigitado) || (float) $precoDigitado < 0) {
        $erro = "Informe um preço válido e não negativo.";

    } else {

        $preco = (float) $precoDigitado;

        $sql = "UPDATE jogos
                SET titulo = :titulo,
                    genero = :genero,
                    preco = :preco
                WHERE id = :id";

        $consulta = $conexao->prepare($sql);

        $consulta->execute([
            ":titulo" => $titulo,
            ":genero" => $genero,
            ":preco" => $preco,
            ":id" => $id
        ]);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Jogo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            color: #4338ca;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            margin-top: 7px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }

        button, .voltar {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 15px;
            background-color: #4338ca;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .voltar {
            background-color: #64748b;
        }

        .erro {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Editar jogo</h1>

    <?php if ($erro !== ""): ?>
        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>
    <?php endif; ?>

    <form action="editar.php?id=<?= $id ?>" method="POST">

        <label for="titulo">Título do jogo:</label>

        <input
            type="text"
            id="titulo"
            name="titulo"
            maxlength="150"
            value="<?= htmlspecialchars($titulo) ?>"
            required
        >

        <label for="genero">Gênero:</label>

        <input
            type="text"
            id="genero"
            name="genero"
            maxlength="100"
            value="<?= htmlspecialchars($genero) ?>"
            required
        >

        <label for="preco">Preço (R$):</label>

        <input
            type="number"
            id="preco"
            name="preco"
            min="0"
            step="0.01"
            value="<?= htmlspecialchars((string) $preco) ?>"
            required
        >

        <button type="submit">Salvar alterações</button>

        <a href="index.php" class="voltar">Cancelar</a>

    </form>

</div>

</body>
</html>