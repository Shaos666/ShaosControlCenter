document.addEventListener("DOMContentLoaded", function () {
  const botoes = document.querySelectorAll(".aba-botao");
  const conteudos = document.querySelectorAll(".aba-conteudo");

  botoes.forEach(botao => {
    botao.addEventListener("click", function () {
      const alvo = this.getAttribute("data-alvo");

      // Remove destaque de todas as abas
      botoes.forEach(b => b.classList.remove("ativo"));
      conteudos.forEach(c => c.classList.remove("ativo"));

      // Ativa a aba clicada
      this.classList.add("ativo");
      document.querySelector(`#${alvo}`).classList.add("ativo");
    });
  });
});

