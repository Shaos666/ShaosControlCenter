<?php
include_once("conexao.php");

$hoje = date('m-d');
$sql = "SELECT nome, tipo FROM aniver WHERE DATE_FORMAT(dn, '%m-%d') = '$hoje'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "<ul>";
    while ($linha = $resultado->fetch_assoc()) {
        echo "<li>🎉 {$linha['nome']} ({$linha['tipo']})</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum aniversariante hoje.</p>";
}
?>
