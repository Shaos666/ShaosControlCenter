<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Exemplo com Abas</title>
  <style>
    body {
      background-color: #111;
      color: #0f0;
      font-family: monospace;
    }

    .tabs {
      display: flex;
      margin-bottom: 10px;
    }

    .tabs button {
      background-color: #000;
      color: #0f0;
      border: 1px solid #0f0;
      padding: 10px;
      cursor: pointer;
      flex: 1;
    }

    .tabs button.active {
      background-color: #0f0;
      color: #000;
    }

    .tab-content {
      display: none;
      border: 1px dotted #0f0;
      padding: 15px;
      border-radius: 8px;
    }

    .tab-content.active {
      display: block;
    }
  </style>
</head>
<body>

<h1>Gestão com Abas</h1>

<div class="tabs">
  <button onclick="showTab('tab1')" class="active">🏷️ Favoritos</button>
  <button onclick="showTab('tab2')">📅 Compromissos</button>
  <button onclick="showTab('tab3')">📊 Estatísticas</button>
</div>

<div id="tab1" class="tab-content active">
  <h2>Favoritos</h2>
  <p>Conteúdo da aba Favoritos...</p>
</div>

<div id="tab2" class="tab-content">
  <h2>Compromissos</h2>
  <p>Conteúdo da aba Compromissos...</p>
</div>

<div id="tab3" class="tab-content">
  <h2>Estatísticas</h2>
  <p>Conteúdo da aba Estatísticas...</p>
</div>

<script>
  function showTab(tabId) {
    // Esconde todos os conteúdos
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    // Remove active dos botões
    document.querySelectorAll('.tabs button').forEach(el => el.classList.remove('active'));
    // Ativa a aba escolhida
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
  }
</script>

</body>
</html>
