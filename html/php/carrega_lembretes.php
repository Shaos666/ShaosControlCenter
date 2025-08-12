<?php
include_once __DIR__ . '/conexao.php';

try {
  $sql = "SELECT id, texto, checked, visivel FROM lembretes ORDER BY data_inclusao DESC";
  $stmt = $conn->query($sql);

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $texto = htmlspecialchars($row['texto']);
    $checked = ($row['checked']) ? 'checked' : '';

    echo "<div class='mod-md-bloco'>";
    echo "  <div class='mod-checkbox'>";
    echo "    <input type='checkbox' data-id='$id' $checked/>";
    echo "  </div>";
    echo "  <div class='mod-descricao'>";
    echo      $texto;
    echo "  </div>";
    echo "</div>";
  }
} catch (PDOException $e) {
  echo "Erro ao carregar lembretes: " . $e->getMessage();
}
