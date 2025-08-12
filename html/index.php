<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ✅ Evita cache ao restaurar sessões -->
  <meta http-equiv="Cache-Control" content="no-store">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Projeto Control Center</title>
  <link rel="icon" href="img/shaos-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/matrix-theme.css"> <!-- CSS externo -->
  <script src="js/morpheus.js" defer></script> <!-- JavaScript externo -->
</head>

<body>
  <div class="page-container">
    <header>
      <div class="header-container">
        <?php include 'php/header.php'; ?>
      </div>
    </header>

    <nav>
      <div class="nav-container">
        <?php include 'php/nav.php'; ?>
        <!--
        <span>Canto Esquerdo</span>
        <span>NAV</span>
        <span>Canto Direito</span>
        -->
    </nav>

    <main id="main-container">
      <section class="blocos bloco-esquerdo">

        <div class="box"> <!-- Compromissos -->
          <div class="cabecalho-box">
            <span class="icone">📋</span>
            <h2 class="box-titulo">Compromissos do Dia</h2>
          </div>
          <div id="compromissos">
            <?php include 'php/carrega_compromissos.php'; ?>
          </div>
          <div class="botao-caixinhas">
            <a href="php/compromissos.php" class="botao-matrix" target="_blank">Organizar Compromissos</a>
          </div>
        </div>

        <div class="box"> <!-- Cotações-->
          <div class="cabecalho-box">
            <span class="icone">📈</span>
            <h2 class="box-titulo">Cotações</h2>
          </div>
          <table class="cotacoes-tabela">
            <tr>
              <td><span class="moeda-nome">Dólar:</span><br><span class="moeda-valor" id="valor-USD">...</span></td>
              <td><span class="moeda-nome">Euro:</span><br><span class="moeda-valor" id="valor-EUR">...</span></td>
            </tr>
            <tr>
              <td><span class="moeda-nome">Bitcoin:</span><br><span class="moeda-valor" id="valor-BTC">...</span></td>
              <td><span class="moeda-nome">Ouro:</span><br><span class="moeda-valor" id="valor-GOLD">...</span></td>
            </tr>
          </table>
        </div>

        <!--
        <div class="box">
          <p>Cotações #Shaos</p>
        </div>
-->

      </section>
      <section class="blocos bloco-central">
        <!-- TÍTULO EM BOX INDEPENDENTE -->

        <!-- CONTAINER DAS DUAS COLUNAS -->
        <div class="center-container">
          <div class="coluna-esquerda">
            <!--<div class="bloco-caixinha-central box"> -->
            <div class="box"> <!-- Lembretes -->
              <div class="cabecalho-box">
                <span class="icone">🎯</span>
                <h2 class="box-titulo">Lembretes</h2>
              </div>
              <div id="lembretes">
                <?php include 'php/carrega_lembretes.php'; ?>
              </div>
              <a href="php/lembretes.php" class="botao-matrix" target="_blank">Organizar Lembretes</a>
            </div>

            <!-- <div class="bloco-caixinha-central box"> -->

            <div class="box"> <!-- Ferramentas Rápidas -->
              <div class="cabecalho-box">
                <span class="icone">🛠️</span>
                <h2 class="box-titulo">Ferramentas<br>Rápidas</h2>
              </div>

              <li style="list-style: none; padding-left: 0;">
                <button onclick="window.open('php/buscar_backup.php', '_blank')" class="botao-neon" style="width:100%;display:flex;align-items:center;gap:8px;border-radius:12px;">
                  <span class="icone">🔍</span>
                  <span class="texto">Buscar Backups</span>
                </button>
              </li>

              <li style="list-style: none; padding-left: 0;">
                <button onclick="window.open('file:///C:/Users/Shaos/Downloads', '_blank')" class="botao-neon" style="width:100%;display:flex;align-items:center;gap:8px;border-radius:12px;">
                  <span class="icone">📁</span>
                  <span class="texto">Acessar Diretórios</span>
                </button>
              </li>

              <li style="list-style: none; padding-left: 0;">
                <button onclick="window.open('scripts/entrar_wsl.bat', '_blank')" class="botao-neon" style="width:100%;display:flex;align-items:center;gap:8px;border-radius:12px;">
                  <span class="icone">🐧</span>
                  <span class="texto">Entrar no WSL</span>
                </button>
              </li>

            </div>
          </div>
          <div class="coluna-direita">

            <!-- <div class="bloco-caixinha-central box" id="aniversariantes-bloco"> -->
            <div class="box" id="aniversariantes-bloco"> <!-- Aniversariantes -->
              <div class="cabecalho-box"> <!-- Aniversariantes -->
                <span class="icone">🎂</span>
                <h2 class="box-titulo">Aniversariantes</h2>
              </div>
              <h3 id="signo">♌ Signo: Leão</h3> <!-- FORA da .cabecalho-box -->
              <div id="aniversariantes">Carregando...</div>
            </div>

            <!-- <div class="bloco-caixinha-central box"> <!-- Favoritos -->
            <div class="box"> <!-- Favoritos -->
              <div class="cabecalho-box">
                <span class="icone">🌐</span>
                <h2 class="box-titulo">Meus Favoritos</h2>
              </div>
              <div class="box-scroll" id="box-favoritos">
                <ul>
                  <?php include 'php/carrega_favoritos.php'; ?>
                </ul>
              </div>
              <a href="php/favoritos.php" class="botao-matrix" target="_blank">Organizar Favoritos</a>
            </div>

            <div class="box"> <!-- Notícias-->
              <div class="cabecalho-box">
                <span class="icone">📰</span>
                <h2 class="box-titulo">Notícias</h2>
              </div>
              <div id="noticiass">Carregando Noticias...</div>
            </div>

          </div>
        </div>
      </section>
      </section>

      <section class="blocos bloco-direito">
        <!--
        <p>Conteúdo do Blocos Direito</p>
        -->
        <div class="box"> <!-- Relógio Analógico-->

          <div class="cabecalho-box">
            <span class="icone">🕒</span>
            <h2 class="box-titulo">Relógio</h2>
          </div>
          <canvas id="analog-clock" width="150" height="150"></canvas>
        </div>

        <div class="box"> <!-- Relógio Digital-->
          <div id="relogio-digital" class="relogio-digital"></div>
        </div>

        <div class="box">
          <div class="cabecalho-box">
            <span class="icone">🗓️</span>
            <h2 class="box-titulo">Calendário</h2>
          </div>
          <div id="fase-lua">Carregando Lua...</div>


          <div> <!-- Calendário-->
            <div class="calendario-header">
              <button onclick="mudarMes(-1)">◀</button>
              <span id="mesAno">Junho 2025</span>
              <button onclick="mudarMes(1)">▶</button>
            </div>
            <div class="calendario-dias">
              <div>Dom</div>
              <div>Seg</div>
              <div>Ter</div>
              <div>Qua</div>
              <div>Qui</div>
              <div>Sex</div>
              <div>Sáb</div>
            </div>
            <div class="calendario-corpo" id="calendario-corpo"></div>
          </div>
        </div>

        <div class="box"> <!-- Datas / Eventos-->
          <div class="cabecalho-box">
            <span class="icone">📌</span>
            <h2 class="box-titulo">Datas/Eventos</h2>
          </div>
          <div id="lista-eventos">Carregando eventos...</div>
        </div>

      </section>
    </main>

    <footer>
      <div class="footer-container">
        <?php include 'php/footer.php'; ?>
        <!--
        <span>Canto Esquerdo</span>
        <span>FOOTER</span>
        <span>Canto Direito</span>
        -->
      </div>
    </footer>
  </div>
</body>

</html>