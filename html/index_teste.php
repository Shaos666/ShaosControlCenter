<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de Tema Dinâmico</title>
  <link id="theme-style" rel="stylesheet" href="css/matrix-theme.css">
  <style>
    /* Tema Matrix (padrão) */
    body {
      background-color: black;
      color: #00ff00;
      font-family: monospace;
      transition: all 0.3s;
    }
    /* Tema Claro */
    body.light-theme {
      background-color: #ffffff;
      color: #000000;
      font-family: sans-serif;
    }
  </style>
</head>
<body>
  <h1>Tema Dinâmico</h1>
  <p>Escolha um tema no menu abaixo para trocar o estilo da página sem recarregar.</p>

  <select onchange="trocarTema(this.value)">
    <option value="matrix-theme">Matrix</option>
    <option value="light-theme">Claro</option>
  </select>

  <script>
    function trocarTema(tema) {
      const estilo = document.getElementById('theme-style');
      estilo.href = 'css/' + tema + '.css';
    }
  </script>
</body>
</html>

