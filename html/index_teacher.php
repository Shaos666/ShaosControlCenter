<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Área do Professor Shaos</title>
  <style>
    body {
      background-color: #1c1c1c;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      margin: 0;
      padding: 20px;
    }

    #dashboard-professor {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 16px;
    }

    .bloco {
      border-radius: 12px;
      padding: 16px;
      box-shadow: 4px 4px 8px rgba(0,0,0,0.5);
      position: relative;
    }

    .bloco::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 10px;
      background-color: rgba(0,0,0,0.1);
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    .planejamento    { background-color: #60a5fa; color: #002b47; }
    .tarefas         { background-color: #fcd34d; color: #3b2f00; }
    .lembretes       { background-color: #fb923c; color: #4b1f00; }
    .anotacoes       { background-color: #6ee7b7; color: #064e3b; }
    .calendario      { background-color: #bfdbfe; color: #1e3a8a; text-align: center; }
    .relogio         { background-color: #fde68a; color: #78350f; text-align: center; font-size: 2rem; padding: 20px; border-radius: 10px; }

    h2 {
      margin-top: 0;
      font-size: 1.2rem;
      text-transform: uppercase;
      border-bottom: 2px dashed rgba(0,0,0,0.2);
    }

    ul {
      padding-left: 16px;
    }

    .tarefas input[type="checkbox"] {
      margin-right: 8px;
    }
  </style>
</head>
<body>
  <h1>🎓 ÁREA DO PROFESSOR SHAOS</h1>
  <div id="dashboard-professor">

    <div class="bloco planejamento">
      <h2>Planejamento</h2>
      <ul>
        <li>08:00 Academia</li>
        <li>10:00 Aula Inglês</li>
        <li>14:00 Projeto X</li>
        <li>18:00 Caminhada</li>
        <li>20:00 Descanso</li>
        <li>22:00 Lazer</li>
      </ul>
    </div>

    <div class="bloco tarefas">
      <h2>Tarefas</h2>
      <ul>
        <li><input type="checkbox"> Criar novo commit no GIT</li>
        <li><input type="checkbox"> Ajustar layout do dashboard</li>
      </ul>
    </div>

    <div class="bloco lembretes">
      <h2>Lembretes</h2>
      <ul>
        <li>💡 Backup dos containers</li>
        <li>📅 Atualizar calendário</li>
        <li>📌 Verificar os logs</li>
      </ul>
    </div>

    <div class="bloco anotacoes">
      <h2>Anotações</h2>
      <ul>
        <li>Links Úteis</li>
        <li>Arq. Locais</li>
        <li>Banco de Dados</li>
      </ul>
    </div>

    <div class="bloco calendario">
      <h2>Abril</h2>
      <p>1 2 3 4 5 6 7</p>
      <p>8 9 10 11 12 13 14</p>
      <p>15 16 17 18 19 20 21</p>
      <p>22 23 24 25 26 27 28</p>
      <p>29 30</p>
    </div>

    <div class="postit-calendario">
      <div class="postit-header">ABRIL</div>
      <div id="calendar-container"></div>
    </div>

    <div class="relogio-retro">
       <canvas id="analog-clock" width="160" height="160"></canvas>
    </div>

    <div class="relogio">🕒 14:32</div>

  </div>
</body>
</html>

