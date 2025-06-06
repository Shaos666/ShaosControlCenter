<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shaos Control Center</title>
  <link rel="stylesheet" href="css/matrix-theme.css">
  <script defer src="js/clock.js"></script>
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

<main class="dashboard-grid">

  <!-- 🗓️ Coluna da Esquerda: Compromissos -->
  <section id="daily-schedule" aria-labelledby="agenda-title">
    <h2 id="agenda-title">Compromissos</h2>
    <table>
      <thead>
        <tr><th>Hora</th><th>Atividade</th></tr>
      </thead>
      <tbody id="agenda-body">
        <!-- Conteúdo será carregado via PHP -->
      </tbody>
    </table>
  </section>

  <!-- 🧠 Coluna Central: Lembretes + Relógio + Aniversário -->
  <section id="notes" aria-labelledby="lembretes-title">
    <h2 id="lembretes-title">Lembretes</h2>
    <ul id="lembretes-list">
      <!-- Conteúdo será carregado via PHP -->
    </ul>
  </section>

  <section id="clock-block" aria-label="Relógio">
    <div class="clock">
      <canvas id="analog-clock" width="150" height="150"></canvas>
      <div id="digital-clock">00:00:00</div>
    </div>
  </section>

  <section id="calendar-block" aria-label="Calendário">
    <h2>Calendário</h2>
    <div id="calendar"></div>
  </section>

  <section id="birthday-block" aria-label="Aniversariante">
    <h2>Aniversariante do Dia</h2>
    <p id="aniver-msg">Carregando...</p>
  </section>

  <!-- 🧰 Coluna da Direita: Links úteis -->
  <section id="tools" aria-labelledby="tools-title">
    <h2 id="tools-title">Ferramentas</h2>
    <ul>
      <li><a href="http://localhost:8082">ApachePHP</a></li>
      <li><a href="http://localhost:9000">Portainer</a></li>
    </ul>
  </section>

  <section id="database" aria-labelledby="database-title">
    <h2 id="database-title">Banco de Dados</h2>
    <ul>
      <li><a href="http://localhost:8080">Adminer</a></li>
      <li><a href="#">Dashboard</a></li>
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
    <ul class="bookmark-list">
      <li><a href="https://chat.openai.com">ChatGPT</a></li>
      <li><a href="https://github.com">GitHub</a></li>
    </ul>
  </section>

</main>

<script>
  // Carrega os compromissos da terça-feira (semana 3)
  fetch('php/carrega_compromissos.php?semana=3')
    .then(response => response.text())
    .then(data => {
      document.getElementById('agenda-body').innerHTML = data;
    });

  // Carrega os lembretes
  fetch('php/carrega_tarefas.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('lembretes-list').innerHTML = data;
    });

  // Carrega aniversariante do dia
  fetch('php/carrega_aniversariante.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('aniver-msg').textContent = data;
    });
</script>

<footer>
  <p>© 2025 - Shaos Control Center | Powered by Foxtrot</p>
</footer>

<script src="js/clock.js"></script>

<script>
function gerarCalendario() {
  const diasSemana = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];
  const hoje = new Date();
  const ano = hoje.getFullYear();
  const mes = hoje.getMonth();

  const primeiroDia = new Date(ano, mes, 1).getDay(); // 0 = domingo
  const totalDias = new Date(ano, mes + 1, 0).getDate();

  let html = `<div><strong>${hoje.toLocaleString('pt-BR', { month: 'long', year: 'numeric' })}</strong></div>`;
  html += '<div class="calendar-grid">';

  diasSemana.forEach(dia => html += `<div class="calendar-header">${dia}</div>`);

  for (let i = 0; i < primeiroDia; i++) {
    html += `<div class="calendar-empty"></div>`;
  }

  for (let d = 1; d <= totalDias; d++) {
    const classeHoje = (d === hoje.getDate()) ? 'calendar-today' : '';
    html += `<div class="calendar-day ${classeHoje}">${d}</div>`;
  }

  html += '</div>';
  document.getElementById('calendar').innerHTML = html;
}

gerarCalendario();
</script>

</body>
</html>
