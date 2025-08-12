<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, "editar_") === 0) {
            $id = str_replace("editar_", "", $key);

            $nome = $_POST["nome_$id"] ?? '';
            $url = $_POST["url_$id"] ?? '';
            $visivel = isset($_POST["visivel_$id"]) ? 1 : 0;

            $stmt = $conn->prepare("UPDATE favoritos SET nome = ?, url = ?, visivel = ?, data_update = CURDATE(), hora_update = CURTIME(), data_alteracao = NOW() WHERE id = ?");
            $stmt->execute([$nome, $url, $visivel, $id]);
        }
    }
}

header("Location: favoritos_4.php");
exit;
