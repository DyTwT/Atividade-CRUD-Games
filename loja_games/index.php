<?php
require_once "conexao.php";

$sql = "SELECT id, titulo, genero, preco, criado_em
        FROM jogos
        ORDER BY id DESC";

$consulta = $conexao->query($sql);
$jogos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catálogo de Games</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #4338ca;
        }

        .botao {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px 0;
            background-color: #4338ca;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .botao:hover {
            background-color: #3730a3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4338ca;
            color: white;
        }

        .editar {
            color: #2563eb;
            text-decoration: none;
            margin-right: 10px;
        }

        .excluir {
            color: #dc2626;
            text-decoration: none;
        }

        .vazio {
            text-align: center;
            padding: 20px;
            color: #64748b;
        }

        @media (max-width: 700px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 12px;
                overflow-x: auto;
            }

            table {
                min-width: 650px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Catálogo de Games</h1>

    <p>Gerencie os jogos cadastrados na loja.</p>

    <a href="criar.php" class="botao">+ Cadastrar novo jogo</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Preço</th>
                <th>Data de cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

            <?php if (count($jogos) > 0): ?>

                <?php foreach ($jogos as $jogo): ?>

                    <tr>
                        <td>
                            <?= (int) $jogo["id"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($jogo["titulo"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($jogo["genero"]) ?>
                        </td>

                        <td>
                            R$ <?= number_format(
                                (float) $jogo["preco"],
                                2,
                                ",",
                                "."
                            ) ?>
                        </td>

                        <td>
                            <?= date(
                                "d/m/Y H:i",
                                strtotime($jogo["criado_em"])
                            ) ?>
                        </td>

                        <td>
                            <a
                                class="editar"
                                href="editar.php?id=<?= (int) $jogo["id"] ?>"
                            >
                                Editar
                            </a>

                            <a
                                class="excluir"
                                href="excluir.php?id=<?= (int) $jogo["id"] ?>"
                                onclick="return confirm('Tem certeza que deseja excluir este jogo?')"
                            >
                                Excluir
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6" class="vazio">
                        Nenhum jogo cadastrado.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>
    </table>

</div>

</body>
</html>