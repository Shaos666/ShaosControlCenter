<?php
require_once __DIR__ . "/conexao.php";

$sql = "SELECT nome FROM aniversariantes WHERE DATE_FORMAT(dn, '%m-%d') = '06-19'";
$stmt = $conn->query($sql);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($dados);

