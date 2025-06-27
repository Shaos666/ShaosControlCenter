document.addEventListener("DOMContentLoaded", () => {
  fetch("php/carrega_compromissos.php")
    .then(res => res.json())
    .then(data => {
      const tabela = document.getElementById("tabela-compromissos");
      tabela.innerHTML = "<tr><th>Hora</th><th>Atividade</th></tr>";
      data.forEach(item => {
        tabela.innerHTML += `<tr><td>${item.horario}</td><td>${item.atividade}</td></tr>`;
      });
    });

  fetch("php/carrega_lembretes.php")
    .then(res => res.json())
    .then(data => {
      const lista = document.getElementById("lista-lembretes");
      lista.innerHTML = "";
      data.forEach(item => {
        lista.innerHTML += `<li>${item.texto}</li>`;
      });
    });

  fetch('php/carrega_aniversariante.php')
  .then(res => {
    console.log("Status HTTP:", res.status);
    return res.text(); // ✅ TRATANDO COMO HTML
  })
  .then(html => {
    document.getElementById("aniversariantes").innerHTML = html;
  })
  .catch(error => {
    console.error("❌ Erro no fetch:", error);
    document.getElementById("aniversariantes").innerHTML = "<li>Erro ao carregar aniversariantes.</li>";
  });
});

function destacarCompromissoVigente() {
  const agora = new Date();
  const minutosAgora = agora.getHours() * 60 + agora.getMinutes();
  const compromissos = Array.from(document.querySelectorAll("#compromissos .item"));
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
  compromissos.forEach(c => c.classList.remove("compromisso-agora"));
  if (selecionado) {
    selecionado.classList.add("compromisso-agora");
  }
}
setInterval(destacarCompromissoVigente, 60000);
destacarCompromissoVigente();

// Chama uma vez ao carregar
marcarCompromissoAtual();

// E repete a cada 30 segundos
setInterval(marcarCompromissoAtual, 30000);
