<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["adicionar"])) {
    $nome = substr(trim($_POST["novo_nome"]), 0, 100);
    $url = substr(trim($_POST["novo_url"]), 0, 255);
    $data = date("Y-m-d");
    $hora = date("H:i:s");

    if ($nome !== "" && $url !== "") {
        $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, data, hora, visivel, data_criacao, data_alteracao) VALUES (?, ?, ?, ?, 1, NOW(), NOW())");
        $stmt->execute([$nome, $url, $data, $hora]);
    }
}

header("Location: favoritos_4.php");
exit;
