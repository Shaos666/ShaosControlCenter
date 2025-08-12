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
  echo "<div class='carga_db_bloco'>";
  foreach ($resultados as $row) {
    $hora = substr($row['hora'], 0, 5);
    echo "<div class='carga_db_linha compromisso_ativo' data-hora='$hora'>
        <span class='carga_db_horario'>$hora</span>
        <span class='carga_db_evento'>{$row['evento']}</span>
      </div>";
  }
  echo "</div>";
} else {
  echo "<p>🕊️ Nenhum compromisso para hoje.</p>";
}
