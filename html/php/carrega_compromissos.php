<?php
require_once('conexao.php');

date_default_timezone_set('America/Sao_Paulo');
$hoje = date('w'); // 0 = domingo, 6 = sábado
$hoje = $hoje + 1; // Alinha com o banco: 1 = domingo

$sql = "SELECT hora, evento FROM compromissos WHERE semana = :hoje ORDER BY hora ASC";
$stmt = $conn->prepare($sql);
$stmt->execute(['hoje' => $hoje]);

$resultados = $stmt->fetchAll();

if ($resultados) {
  echo "<div class='agenda'>";
  foreach ($resultados as $row) {
    $hora = substr($row['hora'], 0, 5);
    echo "<div class='item' data-hora='$hora'><span class='hora'>$hora</span> {$row['evento']}</div>";
  }
  echo "</div>";
} else {
  echo "<p>🕊️ Nenhum compromisso para hoje.</p>";
}
?>
