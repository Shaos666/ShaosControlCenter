<?php
include 'conexao.php';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'incluir') {
  $titulo = trim($_POST['titulo'] ?? '');
  $url = trim($_POST['url'] ?? '');

  if ($titulo === '' || $url === '') {
    $mensagem = '⚠️ Título e URL são obrigatórios.';
  } else {
    try {
      $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, visivel, data_criacao, data_alteracao) VALUES (?, ?, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
      $stmt->execute([$titulo, $url]);
      $mensagem = '✅ Favorito inserido com sucesso!';
    } catch (PDOException $e) {
      $mensagem = '❌ Erro ao inserir: ' . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Favoritos</title>
  <style>
    body {
      background-color: black;
      color: #00ff66;
      font-family: Consolas, monospace;
      margin: 0;
      padding: 0;
    }
    h1 {
      background-color: #111;
      color: #00ff66;
      margin: 0;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #00ff66;
    }
    button#voltar {
      background-color: #222;
      color: #00ff66;
      border: 1px solid #00ff66;
      padding: 6px 12px;
      cursor: pointer;
    }
    main {
      padding: 20px;
    }
    .aba-menu {
      display: flex;
      margin-bottom: 15px;
    }
    .aba-menu button {
      flex: 1;
      background-color: #111;
      border: 1px solid #00ff66;
      color: #00ff66;
      padding: 10px;
      cursor: pointer;
    }
    .aba-menu button.active {
      background-color: #00ff66;
      color: black;
      font-weight: bold;
    }
    .aba {
      display: none;
    }
    .aba.active {
      display: block;
    }
    .mod-aux-box {
      border: 1px solid #00ff66;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      display: flex;
      flex-direction: column;
    }
    .mod-aux-linha {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }
    .mod-aux-linha label {
      width: 80px;
    }
    .mod-aux-input {
      flex: 1;
      margin-right: 10px;
      background-color: #001f00;
      color: #00ff66;
      border: 1px solid #00ff66;
      padding: 5px;
      outline: none;
      caret-color: #00ff66;
    }
    .mod-aux-input:focus {
      outline: auto;
    }
    .mod-aux-contador {
      width: 40px;
      text-align: right;
      margin-right: 15px;
    }
    .mod-aux-save {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .mod-aux-save button {
      background-color: #00ff66;
      color: black;
      font-weight: bold;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }
    footer {
      text-align: center;
      padding: 15px;
      font-size: 11px;
      color: #555;
      border-top: 1px solid #00ff66;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<h1>
  Favoritos - Gerenciamento
  <button id="voltar" onclick="window.history.back()">Voltar</button>
</h1>

<main>
  <div class="aba-menu">
    <button class="tab-btn active" data-target="aba-editar">Editar</button>
    <button class="tab-btn" data-target="aba-incluir">Incluir</button>
    <button class="tab-btn" data-target="aba-historico">Histórico</button>
  </div>

  <!-- INCLUIR -->
  <div id="aba-incluir" class="aba <?= ($_POST['acao'] ?? '') === 'incluir' ? 'active' : '' ?>">
    <?php if ($mensagem): ?>
      <div style="color:#00ff66; margin-bottom:10px;"><?= $mensagem ?></div>
    <?php endif; ?>
    <form method="POST" autocomplete="off">
      <input type="hidden" name="acao" value="incluir">
      <div class="mod-aux-box">
        <div class="mod-aux-linha">
          <label for="titulo-new">Título:</label>
          <input type="text" name="titulo" id="titulo-new" class="mod-aux-input" maxlength="100"
                 value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                 oninput="atualizarContador(this)">
          <div class="mod-aux-contador" id="cont-titulo-new">
            <?= str_pad(strlen($_POST['titulo'] ?? ''), 3, '0', STR_PAD_LEFT) ?>
          </div>
        </div>
        <div class="mod-aux-linha">
          <label for="url-new">URL:</label>
          <input type="text" name="url" id="url-new" class="mod-aux-input" maxlength="255"
                 value="<?= htmlspecialchars($_POST['url'] ?? '') ?>"
                 oninput="atualizarContador(this)">
          <div class="mod-aux-contador" id="cont-url-new">
            <?= str_pad(strlen($_POST['url'] ?? ''), 3, '0', STR_PAD_LEFT) ?>
          </div>
        </div>
        <div class="mod-aux-save">
          <button type="submit">Salvar</button>
        </div>
      </div>
    </form>
  </div>

</main>

<footer>
  FoxTrot Framework • SHAOS MATRIX SYSTEM • 2025
</footer>

<script>
function atualizarContador(input) {
  const id = input.id;
  const contador = document.getElementById("cont-" + id);
  if (contador) {
    contador.innerText = input.value.length.toString().padStart(3, '0');
  }
}

document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.aba').forEach(tab => tab.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(btn.dataset.target).classList.add('active');
  });
});
</script>

</body>
</html>
