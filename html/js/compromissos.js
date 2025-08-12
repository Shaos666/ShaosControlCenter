document.addEventListener("DOMContentLoaded", function () {
  const campos = document.querySelectorAll(".campo-com-contador input");

  campos.forEach(function (input) {
    const span = input.parentElement.querySelector(".caracteres");
    const max = input.getAttribute("maxlength") || 255;

    const atualizarContador = () => {
      const atual = input.value.length;
      span.textContent = String(atual).padStart(3, '0') + "/" + max;
    };

    input.addEventListener("input", atualizarContador);
    atualizarContador(); // inicializa ao carregar a página
  });
});

