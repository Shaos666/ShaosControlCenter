/*
 * morpheus.js - O Arquiteto do Controle
 * =====================================
 * Sistema: Shaos Matrix Control Center
 * Versão: 2025
 * Autores: Shaos 👾 & FoxTrot 🦊
 *
 * ░█▀▀░█░█░█▀█░█▀▄░█▀▀░█░█░█▀▀
 * ░▀▀█░█░█░█░█░█░█░█▀▀░▀▄▀░▀▀█
 * ░▀▀▀░▀▀▀░▀▀▀░▀▀░░▀▀▀░░▀░░▀▀▀
 *
 * -------------------------------------
 * ÍNDICE DE FUNÇÕES IMPLEMENTADAS:
 * [01] Compromissos do Dia (com destaque automático)
 * [02] Relógio Digital
 * [03] Relógio Analógico
 * [04] Calendário
 * [05] Carregamento de Compromissos (via fetch)
 * [06] Carregamento de Lembretes (via fetch)
 * [07] Carregamento de Aniversariantes (via fetch)
 * [08] Carregamento de Favoritos (via fetch)
 * [09] Status dos Serviços (Apache, MariaDB, etc.)
 * [10] Abas dos Módulos (Compromissos, Favoritos e Lembretes)
 * [11] Contador dos Módulos (Compromissos, Favoritos e Lembretes)
 * [11] Módulos - Contador de Caracteres
 * [12] Recarregar Favoritos (via redirect ou fetch)
 * [13] Inicialização do Sistema
 * [12] Recarregar Favoritos (via redirect ou fetch)
*  [13] Carregar Eventos Comemorativos do Mês
*  [14] Carregar Fase da Lua
*  [15] Função: carregar Fase da Lua
*  [16] Carregar Cotações 
 */


// ═══════════════════════════════════════════════
// [01] COMPROMISSOS DO DIA
// ═══════════════════════════════════════════════
function destacarCompromissoVigente() {
  const agora = new Date();
  const minutosAgora = agora.getHours() * 60 + agora.getMinutes();
  const compromissos = Array.from(document.querySelectorAll(".carga_db_linha"));
  let selecionado = null;

  for (let i = 0; i < compromissos.length; i++) {
    const horaStr = compromissos[i].dataset.hora;
    const [hh, mm] = horaStr.split(":").map(Number);
    const minutosCompromisso = hh * 60 + mm;

    const proximo = compromissos[i + 1];
    let minutosProximo = 24 * 60;
    if (proximo) {
      const [hhNext, mmNext] = proximo.dataset.hora.split(":").map(Number);
      minutosProximo = hhNext * 60 + mmNext;
    }

    if (minutosAgora >= minutosCompromisso && minutosAgora < minutosProximo) {
      selecionado = compromissos[i];
      break;
    }
  }

  compromissos.forEach(c => c.classList.remove("compromisso_ativo"));
  if (selecionado) {
    selecionado.classList.add("compromisso_ativo");
  }
}

// ═══════════════════════════════════════════════
// [02] RELÓGIO DIGITAL
// ═══════════════════════════════════════════════
function updateDigitalClock() {
  const now = new Date();
  const timeString = now.toLocaleTimeString('pt-BR');
  const clock = document.getElementById('relogio-digital');
  if (clock) clock.textContent = timeString;
}

// ═══════════════════════════════════════════════
// [02.5] Iniciar Relógios (digital e analógico)
// ═══════════════════════════════════════════════
function iniciarRelogios() {
  updateDigitalClock();
  setInterval(updateDigitalClock, 1000);
  drawMatrixClock();
  setInterval(drawMatrixClock, 1000);
}

// ═══════════════════════════════════════════════
// [03] RELÓGIO ANALÓGICO
// ═══════════════════════════════════════════════
function drawMatrixClock() {
  const canvas = document.getElementById("analog-clock");
  if (!canvas) return;

  const ctx = canvas.getContext("2d");
  const radius = canvas.height / 2;
  ctx.reset?.();
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.translate(radius, radius);

  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  const gradient = ctx.createRadialGradient(0, 0, radius * 0.95, 0, 0, radius * 1.05);
  gradient.addColorStop(0, "#003300");
  gradient.addColorStop(0.5, "#00ff00");
  gradient.addColorStop(1, "#003300");

  ctx.beginPath();
  ctx.arc(0, 0, radius * 0.95, 0, 2 * Math.PI);
  ctx.fillStyle = "black";
  ctx.fill();

  ctx.strokeStyle = "#00ff00";
  ctx.lineWidth = radius * 0.066;
  ctx.stroke();

  ctx.beginPath();
  ctx.arc(0, 0, radius * 0.05, 0, 2 * Math.PI);
  ctx.fillStyle = "#00ff00";
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  ctx.font = radius * 0.15 + "px 'Courier New', monospace";
  ctx.textBaseline = "middle";
  ctx.textAlign = "center";
  ctx.fillStyle = "#00ff00";

  for (let num = 1; num <= 12; num++) {
    const ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius * 0.82);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius * 0.82);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius) {
  const now = new Date();
  let hour = now.getHours();
  let minute = now.getMinutes();
  let second = now.getSeconds();

  hour = hour % 12;
  hour = (hour * Math.PI / 6) + (minute * Math.PI / (6 * 60)) + (second * Math.PI / (360 * 60));
  drawHand(ctx, hour, radius * 0.5, radius * 0.06);

  minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
  drawHand(ctx, minute, radius * 0.75, radius * 0.06);

  second = (second * Math.PI / 30);
  drawHand(ctx, second, radius * 0.85, radius * 0.015, "#00ffcc");
}

function drawHand(ctx, pos, length, width, color = "#00ff00") {
  ctx.beginPath();
  ctx.lineWidth = width;
  ctx.lineCap = "round";
  ctx.moveTo(0, 0);
  ctx.rotate(pos);
  ctx.lineTo(0, -length);
  ctx.strokeStyle = color;
  ctx.stroke();
  ctx.rotate(-pos);
}

// ═══════════════════════════════════════════════
// [04] CALENDÁRIO
// ═══════════════════════════════════════════════
let dataAtual = new Date();
function renderizarCalendario() {
  const mesAno = document.getElementById("mesAno");
  const corpo = document.getElementById("calendario-corpo");
  const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
                 "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
  const ano = dataAtual.getFullYear();
  const mes = dataAtual.getMonth();
  mesAno.textContent = `${meses[mes]} ${ano}`;
  corpo.innerHTML = "";

  const primeiroDia = new Date(ano, mes, 1).getDay();
  const diasNoMes = new Date(ano, mes + 1, 0).getDate();

  for (let i = 0; i < primeiroDia; i++) corpo.innerHTML += `<div></div>`;
  const hoje = new Date();
  for (let dia = 1; dia <= diasNoMes; dia++) {
    const ehHoje = dia === hoje.getDate() && mes === hoje.getMonth() && ano === hoje.getFullYear();
    corpo.innerHTML += `<div class="${ehHoje ? "hoje" : ""}">${String(dia).padStart(2, '0')}</div>`;
  }
}
function mudarMes(delta) {
  dataAtual.setMonth(dataAtual.getMonth() + delta);
  renderizarCalendario();
}
document.addEventListener("DOMContentLoaded", renderizarCalendario);


//function mudarMes(delta) {
//  const dataAtual = new Date();
//  dataAtual.setMonth(dataAtual.getMonth() + delta);
//  renderizarCalendario();  
//}
function mudarMes(delta) {
  dataAtual.setMonth(dataAtual.getMonth() + delta);
  renderizarCalendario();
}

// Eventos dos botões de navegação do calendário
document.addEventListener("DOMContentLoaded", () => {
  const btnAnterior = document.getElementById("btn-anterior");
  const btnProximo = document.getElementById("btn-proximo");

  if (btnAnterior && btnProximo) {
    btnAnterior.addEventListener("click", () => {
      dataAtual.setMonth(dataAtual.getMonth() - 1);
      renderizarCalendario();
    });

    btnProximo.addEventListener("click", () => {
      dataAtual.setMonth(dataAtual.getMonth() + 1);
      renderizarCalendario();
    });
  }
});


// ═══════════════════════════════════════════════
// [05] FETCH: CARREGAMENTO DE COMPROMISSOS
// ═══════════════════════════════════════════════
function carregarCompromissos() {
  fetch("php/carrega_compromissos.php")
    .then(resposta => resposta.text())
    .then(html => {
      const destino = document.getElementById("compromissos-bloco");
      if (destino) destino.innerHTML = html;
    })
    .catch(erro => console.error("Erro ao carregar compromissos:", erro));
}

// ═══════════════════════════════════════════════
// [06] FETCH: CARREGAMENTO DE LEMBRETES
// ═══════════════════════════════════════════════
function carregarLembretes() {
  fetch("php/carrega_lembretes.php")
    .then(resposta => resposta.text())
    .then(html => {
      const destino = document.getElementById("lembretes-bloco");
      if (destino) destino.innerHTML = html;
    })
    .catch(erro => console.error("Erro ao carregar lembretes:", erro));
}


// ═══════════════════════════════════════════════
// [07] FETCH: CARREGAMENTO DE ANIVERSARIANTES
// ═══════════════════════════════════════════════
function carregarAniversariantes() {
  fetch("php/carrega_aniversariante.php")
    .then(resposta => resposta.text())
    .then(html => {
      const destino = document.getElementById("aniversariantes");
      if (destino) destino.innerHTML = html;
    })
    .catch(erro => console.error("Erro ao carregar aniversariantes:", erro));
}

// ═══════════════════════════════════════════════
// [08] FETCH: CARREGAMENTO DE FAVORITOS
// ═══════════════════════════════════════════════
function carregarFavoritos() {
  fetch("php/carrega_favoritos.php")
    .then(resposta => resposta.text())
    .then(html => {
      const destino = document.getElementById("favoritos-bloco");
      if (destino) destino.innerHTML = html;
    })
    .catch(erro => console.error("Erro ao carregar favoritos:", erro));
}


// ═══════════════════════════════════════════════
// [09] STATUS DOS SERVIÇOS
// ═══════════════════════════════════════════════
function carregarStatusServicos() {
  fetch("php/status_servicos.php")
    .then(response => response.text())
    .then(html => {
      const container = document.getElementById("status-servicos-bloco");
      if (container) container.innerHTML = html;
    })
    .catch(error => console.error("Erro ao carregar status dos serviços:", error));
}

// ═══════════════════════════════════════════════
// [10] ABAS DOS MÓDULOS
// ═══════════════════════════════════════════════
function modOpenTab(evt, tabId) {
  const tablinks = document.querySelectorAll(".mod-tablink");
  const tabcontents = document.querySelectorAll(".mod-tabcontent");

  tabcontents.forEach(content => content.style.display = "none");
  tablinks.forEach(link => link.classList.remove("active"));

  const target = document.getElementById(tabId);
  if (target) target.style.display = "block";

  evt.currentTarget.classList.add("active");
}

// ═══════════════════════════════════════════════
// [11] CONTADOR DE CARACTERES
// ═══════════════════════════════════════════════
function atualizarContador(input) {
  const span = input.parentElement?.nextElementSibling;
  if (span) {
    const valor = input.value.length;
    span.textContent = valor.toString().padStart(3, '0');
  }
}

// ═══════════════════════════════════════════════
// [12] RECARREGAR FAVORITOS (via redirect ou fetch)
// ═══════════════════════════════════════════════
function recarregarFavoritos(metodo = "fetch") {
  if (metodo === "fetch") {
    carregarFavoritos();
  } else {
    window.location.href = "favoritos.php";
  }
}

// ═══════════════════════════════════════════════
// [13] CARREGAR EVENTOS COMEMORATIVOS DO MÊS
// ═══════════════════════════════════════════════
function carregarEventosComemorativos() {
  fetch("php/carrega_eventos.php")
    .then((resposta) => resposta.text())
    .then((html) => {
      const container = document.getElementById("lista-eventos")
      if (container) {
        container.innerHTML = html;
        console.log("📅 Eventos carregados com sucesso.");
      }
    })
    .catch((erro) => {
      console.error("Erro ao carregar eventos:", erro);
    });
}

// ═══════════════════════════════════════════════
// [14] CARREGAR FASE DA LUA
// ═══════════════════════════════════════════════
function carregarFaseLua() {
  fetch("php/fase_lua.php")
    .then((resposta) => resposta.text())
    .then((html) => {
      const container = document.getElementById("fase-lua");
      if (container) {
        container.innerHTML = html;
        console.log("🌙 Fase da Lua carregada com sucesso.");
      }
    })
    .catch((erro) => {
      console.error("Erro ao carregar fase da lua:", erro);
    });
}

// ════════════════════════════════════════
// [15] Função: carregar Fase da Lua
// ════════════════════════════════════════
function carregarFaseLua() {
  console.groupCollapsed("🌒 Carregando Fase da Lua...");
  fetch("php/fase_lua.php")
    .then(response => response.text())
    .then(data => {
      document.getElementById("fase-lua").innerHTML = data;
    })
    .catch(error => console.error("Erro ao carregar fase da Lua:", error));
  console.groupEnd();
}

// ═══════════════════════════════════════════════
// [16] CARREGAR COTAÇÕES
// ═══════════════════════════════════════════════
function carregarCotacoes() {
  fetch("php/carrega_cotacoes.php")
    .then(res => res.json())
    .then(dados => {
      const moedas = ["USD", "EUR", "BTC", "GOLD"];

      moedas.forEach(sigla => {
        const span = document.getElementById("valor-" + sigla);
        if (span && dados[sigla]) {
          span.textContent = "R$ " + parseFloat(dados[sigla]).toLocaleString('pt-BR');
        }
      });

      console.log("📈 Cotações atualizadas com sucesso.");
    })
    .catch(erro => {
      console.error("Erro ao carregar cotações:", erro);
    });
}
 
// ═══════════════════════════════════════════════
// [16] Abrir Abas
// ═══════════════════════════════════════════════
function abrirAba(evt, nomeAba) {
    var i, tabcontent, tablinks;

    // Oculta todo o conteúdo das abas
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove a classe 'active' de todos os botões
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Mostra a aba selecionada e marca o botão como ativo
    document.getElementById(nomeAba).style.display = "block";
    evt.currentTarget.classList.add("active");
}

// ═══════════════════════════════════════════
// [17] Gatilho Inicial: Coleta de Cotações
// ═══════════════════════════════════════════

document.addEventListener("DOMContentLoaded", () => {
  console.groupCollapsed("🪙 Coletando cotações via Python...");

  fetch("php/rodar_coletor.php")
    .then(response => response.text())
    .then(data => {
      console.log("📥 Cotação atualizada com sucesso:", data);
    })
    .catch(error => {
      console.error("❌ Erro ao executar coletor de cotações:", error);
    });

  console.groupEnd();
});

// ═════════════════════════════════════
// [18] Atualização Diária Programada
// ═════════════════════════════════════

// Salva o dia atual no carregamento
let diaAtual = new Date().getDate();

// Verifica a cada 1 minuto se o dia mudou
setInterval(() => {
    const agora = new Date();
    const novoDia = agora.getDate();

    if (novoDia !== diaAtual) {
        console.groupCollapsed("🔁 Virou o dia! Atualizando os módulos diários...");

        // Atualiza variáveis internas
        diaAtual = novoDia;

        // Chamada dos módulos
        if (typeof carregarAniversariantes === "function") carregarAniversariantes();
        if (typeof carregarCompromissos === "function") carregarCompromissos();
        if (typeof carregarLembretes === "function") carregarLembretes();
        if (typeof carregarEventos === "function") carregarEventos();
        if (typeof atualizarCalendario === "function") atualizarCalendario();

        console.groupEnd();
    }
}, 60000); // 1 minuto

// ═════════════════════════════════════
// [19] Atualização dos Favoritos
// ═════════════════════════════════════
function recarregarFavoritosBox() {
    const box = window.opener?.document.getElementById("box-favoritos");
    if (!box) return;
    fetch("php/carrega_favoritos.php")
        .then(resp => resp.text())
        .then(html => box.innerHTML = html)
        .catch(err => console.error("Erro ao recarregar favoritos:", err));
}        

// INICIALIZAÇÃO DO SISTEMA (EXTENSÃO MORPHEUS)
// ═══════════════════════════════════════════════
document.addEventListener("DOMContentLoaded", () => {

  // Atualiza contador de caracteres
  document.querySelectorAll(".mod-campo-com-contador input[type='text']").forEach(input => {
    const span = input.parentElement.querySelector('.mod-caracteres');
    if (span) {
      span.textContent = input.value.length.toString().padStart(3, '0');
    }
    input.addEventListener("input", () => {
      if (span) span.textContent = input.value.length.toString().padStart(3, '0');
    });
  });

  // Abre a primeira aba se existir
  const primeiraAba = document.querySelector(".mod-tablink");
  if (primeiraAba) primeiraAba.click();

  // Carrega compromissos
  if (typeof carregarCompromissos === "function") {
    console.groupCollapsed("📅 Carregando Compromissos...");
    carregarCompromissos();
    console.groupEnd();
  }

  // Carrega lembretes
  if (typeof carregarLembretes === "function") {
    console.groupCollapsed("🎯 Carregando Lembretes...");
    carregarLembretes();
    console.groupEnd();
  }

  // Carrega aniversariantes
  if (typeof carregarAniversariantes === "function") {
    console.groupCollapsed("🎂 Carregando Aniversariantes...");
    carregarAniversariantes();
    console.groupEnd();
  }

  // Carrega eventos comemorativos
  if (typeof carregarEventosComemorativos === "function") {
    console.groupCollapsed("🎉 Carregando Eventos Comemorativos...");
    carregarEventosComemorativos();
    console.groupEnd();
  }

  // Inicia destaque de compromisso atual
  if (typeof destacarCompromissoVigente === "function") {
    console.groupCollapsed("⏱️ Iniciando Destaque de Compromissos...");
    destacarCompromissoVigente(); // Primeira execução imediata
    setInterval(destacarCompromissoVigente, 60000);
    console.groupEnd();
  }

  // Inicia relógios e calendário
  if (typeof iniciarRelogios === "function") {
    console.groupCollapsed("⏰ Iniciando Relógios e Calendário...");
    renderizarCalendario();
    iniciarRelogios();
    console.groupEnd();
  }

  // Carrega as data comemorativas do mês
  carregarEventosComemorativos();

  // Carrega a fase da Lua
  carregarFaseLua();

  // Carrega Cotações de Valores
if (typeof carregarCotacoes === "function") {
  console.groupCollapsed("📈 Carregando Cotações...");
  carregarCotacoes();
  console.groupEnd();
}

  // Gatilho opcional: Executa Python para atualizar cotacoes.json
  console.groupCollapsed("🪙 Coletando cotações via Python...");
  fetch("php/rodar_coletor.php")
    .then(response => response.text())
    .then(data => {
      console.log("📥 Cotação atualizada com sucesso:", data);
    })
    .catch(error => {
      console.error("❌ Erro ao executar coletor de cotações:", error);
    });
  console.groupEnd();

  
  // Se recarregou de aba restaurada
  if (performance.navigation.type === performance.navigation.TYPE_BACK_FORWARD) {
    location.reload(true);
  }



  
});

/*
 * --------------------------------------
 * "Entre o sonho e o sistema, entre o agora e o possível,
 * Morpheus observa e comanda."
*/