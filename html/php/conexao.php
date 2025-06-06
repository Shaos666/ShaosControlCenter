<?php
$host = 'mariadb_foxtrot';
$usuario = 'shaos';
$senha = 'Code4Shaos!';
$banco = 'dashboarddb';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
