<?php
require_once('conexao.php');

$sql = "SELECT texto FROM lembretes WHERE visivel = 1 ORDER BY dt_inc DESC, hr_inc DESC LIMIT 10";
$stmt = $conn->query($sql);
$lembretes = $stmt->fetchAll();

if ($lembretes) {
  echo "<ul>";
  foreach ($lembretes as $item) {
    echo "<li>{$item['texto']}</li>";
  }
  echo "</ul>";
} else {
  echo "<p>📭 Nenhum lembrete visível no momento.</p>";
}
?>
