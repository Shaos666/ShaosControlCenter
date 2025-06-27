<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>SHAOS MATRIX CONTROL CENTER - TESTE</title>
  <link rel="icon" href="img/shaos-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/matrix-theme.css">  
  <script src="js/clock.js" defer></script>
  <script src="js/dashboard.js" defer></script>
</head>
<body>

  <header>
    <h1>
      <span class="shaos">SHAOS</span>
      <span class="matrix">Matrix</span><br>
      <span class="control">Control Center</span>
    </h1>
  </header>

  <nav>
    <div class="status-bar">
      <?php
        $status_path = __DIR__ . '/status_dashboard.html';
        if (file_exists($status_path)) {
            echo file_get_contents($status_path);
        } else {
            echo "<span>Status indisponível</span>";
        }
      ?>
    </div>
  </nav>

  <main id="main-container">
    <div class="sidebar-left">
      <section class="caixa_verde_esq">
        <h2>📅 Compromissos do Dia</h2>
        <div id="compromissos">
          <?php include 'php/carrega_compromissos.php'; ?>
        </div>
      </section>
    </div>

    <div class="content">
      <section class="caixa_verde_centro_e">
        <h2>🎯 Lembretes</h2>
        <div id="lembretes">
          <?php include 'php/carrega_tarefas.php'; ?>
        </div>
      </section>

      <section class="caixa_verde_centro_d">
        <h2>🎂 Aniversariantes</h2>
        <div id="aniversariantes">Carregando...</div>
      </section>

      <section class="caixa_verde_centro_d">
        <h2>🛠️ Ferramentas Rápidas</h2>
        <ul>
          <li><a href="#">🔍 Buscar Backups</a></li>
          <li><a href="#">📁 Acessar Diretórios</a></li>
          <li><a href="#">🐧 Entrar no WSL</a></li>
        </ul>
      </section>
    </div>

    <div class="sidebar-right">
      <section class="caixa_verde_dir">
        <h2>🕒 Relógio</h2>
        <canvas id="analog-clock" width="150" height="150"></canvas>
        <div id="digital-clock"><span id="hora-digital">Carregando...</span></div>
      </section>

      <section class="caixa_verde_dir">
        <h2>🗓️ Calendário</h2>
        <?php include 'php/calendario.php'; ?>
      </section>
    </div>
  </main>

  <script>
    console.log("🔁 Script de aniversariantes executado!");

    fetch('php/carrega_aniversariante.php')
      .then(res => res.text())
      .then(html => {
        console.log("✅ HTML recebido:", html);
        document.getElementById("aniversariantes").innerHTML = html;
      })
      .catch(err => {
        console.error("❌ Erro no fetch:", err);
        document.getElementById("aniversariantes").innerHTML = "<li>Erro ao carregar aniversariantes.</li>";
      });
  </script>

  <footer>
    <p>&copy; 2025 Shaos Systems — Desenvolvido com 🧠 e ⚡ por FoxTrot</p>
  </footer>

</body>
</html>
