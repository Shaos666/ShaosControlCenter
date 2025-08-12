<?php
 include_once __DIR__ . '/conexao.php';

 date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Gestão com Abas - Compromissos</title>
  <link rel="stylesheet" href="../css/matrix-theme.css">
  <style>
    .tabs-matrix {
      display: flex;
      justify-content: center;
      margin-bottom: 15px;
    }

    .tab-btn {
      background: #111;
      color: #0f0;
      border: 1px solid #0f0;
      padding: 8px 16px;
      margin: 0 5px;
      font-family: monospace;
      cursor: pointer;
      border-radius: 8px;
    }

    .tab-btn.active {
      background-color: #0f0;
      color: #111;
    }

    .tab-content {
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }

    .tab-content.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
  </style>
</head>

<body>
  <h1 class="centralizar">Gestão de Compromissos</h1>

  <div class="tabs-matrix">
    <button class="tab-btn active" onclick="trocarAba(1)">📋 Listagem e Atualizações</button>
    <button class="tab-btn" onclick="trocarAba(2)">➕ Inclusão de Compromissos</button>
    <button class="tab-btn" onclick="trocarAba(3)">📈 Estatísticas</button>
  </div>

  <div id="tab1" class="tab-content active">
    <?php include 'php/compromissos_listar.php'; ?>
  </div>

  <div id="tab2" class="tab-content">
    <?php include 'php/compromissos_incluir.php'; ?>
  </div>

  <div id="tab3" class="tab-content">
    <?php include 'php/compromissos_estatisticas.php'; ?>
  </div>

  <script>
    function trocarAba(n) {
      document.querySelectorAll('.tab-btn').forEach((btn, i) => {
        btn.classList.toggle('active', i === n - 1);
      });
      document.querySelectorAll('.tab-content').forEach((tab, i) => {
        tab.classList.toggle('active', i === n - 1);
      });
    }
  </script>
</body>

</html>

