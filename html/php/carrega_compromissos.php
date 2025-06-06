<?php
include_once("conexao.php");

$hoje = date('N'); // 1 = Segunda ... 7 = Domingo
$sql = "SELECT hora, evento FROM programacao WHERE semana = $hoje ORDER BY hora";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo '<table><tbody>';
    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr><td>{$linha['hora']}</td><td>{$linha['evento']}</td></tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<p>Sem compromissos para hoje.</p>';
}
?>
