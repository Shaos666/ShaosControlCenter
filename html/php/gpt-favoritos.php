
<?php
// favoritos_demo.php
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Favoritos - Teste</title>
  <link rel="stylesheet" href="../css/matrix-theme.css">
  <script src="../js/morpheus.js" defer></script>
  <style>
    .mod-campo-com-contador {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .mod-caracteres {
      color: #0f0;
      font-family: monospace;
      font-size: 1.2em;
    }
    .mod-form-favorito {
      padding: 12px;
      border: 1px dotted #0f0;
      background: #000;
      width: 360px;
      margin: 20px auto;
    }
  </style>
</head>
<body class="mod-auxiliar-body">
  <div class="mod-form-favorito">
    <h2 style="color:#0f0;text-align:center;">Incluir Favorito</h2>
    <form method="POST" onsubmit="event.preventDefault();">
      <div class="mod-campo-com-contador">
        <input type="text" name="titulo" maxlength="100" placeholder="Título do favorito" oninput="atualizarContador(this)">
        <span class="mod-caracteres">000</span>
      </div>
      <br>
      <div class="mod-campo-com-contador">
        <input type="text" name="url" maxlength="255" placeholder="https://..." oninput="atualizarContador(this)">
        <span class="mod-caracteres">000</span>
      </div>
      <br>
      <div style="text-align:center;">
        <input type="submit" value="Salvar" class="botao-matrix">
      </div>
    </form>
  </div>

  <script>
    function atualizarContador(input) {
      const contador = input.parentElement.querySelector('.mod-caracteres');
      contador.textContent = input.value.length.toString().padStart(3, '0');
    }
  </script>
</body>
</html>
