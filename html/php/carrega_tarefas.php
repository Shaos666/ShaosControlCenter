<?php
include_once("conexao.php");

$sql = "SELECT texto FROM tarefas WHERE visivel = TRUE ORDER BY dt_inc DESC, hr_inc DESC LIMIT 10";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "<ul>";
    while ($linha = $resultado->fetch_assoc()) {
        echo "<li>- {$linha['texto']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Sem tarefas visíveis.</p>";
}
?>
