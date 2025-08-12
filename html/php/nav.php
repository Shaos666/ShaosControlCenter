<?php
// Arquivo: php/nav.php
// Objetivo: Atalhos do Dashboard, personalizável por tema

// Podemos futuramente carregar variáveis de sessão, tema, usuário, etc.
?>

<div class="status-bar">
  <?php    
    $status_path = realpath(__DIR__ . '/../status_dashboard.html');
    if (file_exists($status_path)) {
      echo file_get_contents($status_path);
    } else {
      echo "<span>Status indisponível</span>";
  }
  ?>
</div>