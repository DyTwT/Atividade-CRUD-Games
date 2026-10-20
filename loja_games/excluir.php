<?php
require_once "conexao.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"]) || (int) $_GET["id"] < 1) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM jogos WHERE id = :id";

$consulta = $conexao->prepare($sql);
$consulta->execute([":id" => $id]);

header("Location: index.php");
exit;
?>