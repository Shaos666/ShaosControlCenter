<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>SHAOS MATRIX CONTROL CENTER</title>
  <link rel="stylesheet" href="css/matrix-theme.css">
  <script src="js/clock.js" defer></script>
  <script src="js/dashboard.js" defer></script> <!-- <-- este volta aqui -->
</head>
<body>

  <header>
    <h1>SHAOS MATRIX CONTROL CENTER</h1>
  </header>

  <nav>
    <div class="status-bar">
      <?php include 'php/status_servicos.php'; ?>
    </div>
  </nav>

  <main>
    <div class="sidebar-left">
      <section class="caixa verde">
        <h2>📅 Compromissos do Dia</h2>
        <div id="compromissos">
          <?php include 'php/carrega_compromissos.php'; ?>
        </div>
      </section>
    </div>

    <div class="content">
      <section class="caixa verde">
        <h2>🎯 Lembretes</h2>
        <div id="lembretes">
          <?php include 'php/carrega_tarefas.php'; ?>
        </div>
      </section>

      <section class="caixa verde">
        <h2>🎂 Aniversariantes</h2>
        <div id="aniversariantes">Carregando...</div>
      </section>

      <section class="caixa verde">
        <h2>🛠️ Ferramentas Rápidas</h2>
        <ul>
          <li><a href="#">🔍 Buscar Backups</a></li>
          <li><a href="#">📁 Acessar Diretórios</a></li>
          <li><a href="#">🐧 Entrar no WSL</a></li>
        </ul>
      </section>
    </div>

    <div class="sidebar-right">
      <section class="caixa verde relogio">
        <h2>🕒 Relógio</h2>
        <canvas id="analog-clock" width="150" height="150"></canvas>
        <div id="digital-clock"><span id="hora-digital">Carregando...</span></div>
      </section>

      <section class="caixa verde">
        <h2>🗓️ Calendário</h2>
        <?php include 'php/calendario.php'; ?>
      </section>
    </div>
  </main>
<script>
console.log("🔁 Script de aniversariantes executado!");

fetch('php/carrega_aniversariante.php')
  .then(res => res.json())
  .then(dados => {
    // ...
  })
</script>
  <footer>
    <p>&copy; 2025 Shaos Systems — Desenvolvido com 🧠 e ⚡ por FoxTrot</p>
  </footer>

</body>
</html>
