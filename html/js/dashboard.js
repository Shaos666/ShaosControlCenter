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
    return res.json();
  })
  .then(dados => {
    let html = "<ul>";
    if (dados.length === 0) {
      html = "<p>🎈 Nenhum aniversariante hoje.</p>";
    } else {
      dados.forEach(p => html += `<li>🎉 ${p.nome}</li>`);
      html += "</ul>";
    }
    document.getElementById("aniversariantes").innerHTML = html;
  })
  .catch(erro => {
    console.error("Erro no fetch:", erro);
    document.getElementById("aniversariantes").innerHTML =
      "<p style='color: red;'>Erro ao carregar aniversariantes.</p>";
  });
});
