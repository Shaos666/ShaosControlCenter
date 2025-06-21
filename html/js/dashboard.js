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
