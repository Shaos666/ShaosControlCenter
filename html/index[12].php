<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shaos Matrix Control Center</title>
  <link rel="stylesheet" href="css/matrix-theme.css">
</head>
<body>
  <header>
    <h1>SHAOS MATRIX CONTROL CENTER</h1>
  </header>

  <section id="status-bar" aria-label="Status dos serviços">
    <ul>
      <li>Apache: <span class="ok">[OK]</span></li>
      <li>MariaDB: <span class="ok">[OK]</span></li>
      <li>Git: <span class="ok">[OK]</span></li>
      <li>Docker: <span class="ok">[OK]</span></li>
      <li>Backup: <span class="warn">[WARN]</span></li>
    </ul>
  </section>

  <main>
    <section id="daily-schedule" aria-labelledby="agenda-title">
      <h2 id="agenda-title">Compromissos</h2>
      <?php include_once("php/carrega_compromissos.php"); ?>
    </section>

    <section id="notes" aria-labelledby="lembretes-title">
      <h2 id="lembretes-title">Lembretes</h2>
      <?php include_once("php/carrega_tarefas.php"); ?>
    </section>

    <section id="clock-block" aria-label="Relógio">
      <div class="clock">
        <canvas id="analog-clock" width="150" height="150"></canvas>
        <div id="digital-clock">14:28:09</div>
      </div>
    </section>

    <section id="tools" aria-labelledby="tools-title">
      <h2 id="tools-title">Ferramentas</h2>
      <ul>
        <li><a href="http://localhost:8082" target="_blank">ApachePHP</a></li>
        <li><a href="http://localhost:9000" target="_blank">Portainer</a></li>
      </ul>
    </section>

    <section id="database" aria-labelledby="database-title">
      <h2 id="database-title">Banco de Dados</h2>
      <ul>
        <li><a href="http://localhost:8080" target="_blank">Adminer</a></li>
        <li><a href="http://localhost:8083" target="_blank">Dashboard</a></li>
      </ul>
    </section>

    <section id="files" aria-labelledby="files-title">
      <h2 id="files-title">Arquivos Locais</h2>
      <ul>
        <li><a href="#">Documentos</a></li>
        <li><a href="#">Manuais</a></li>
      </ul>
    </section>

    <section id="bookmarks" aria-labelledby="bookmarks-title">
      <h2 id="bookmarks-title">Favoritos</h2>
      <ul>
        <li><a href="https://chat.openai.com" target="_blank">ChatGPT</a></li>
        <li><a href="https://github.com" target="_blank">GitHub</a></li>
      </ul>
    </section>

    <section id="aniver" aria-labelledby="aniver-title">
      <h2 id="aniver-title">Aniversariante do Dia</h2>
      <?php include_once("php/carrega_aniversariante.php"); ?>
    </section>
  </main>

  <footer>
    <p>© 2025 - Shaos Control Center | Powered by Foxtrot</p>
  </footer>

  <script src="js/clock.js"></script>
</body>
</html>

