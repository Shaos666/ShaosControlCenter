// favoritos.js - Script personalizado para gerenciamento dos campos de texto com contador
// Criado por Shaos e FoxTrot em 2025

document.addEventListener("DOMContentLoaded", function () {
  console.log("🚀 Script favoritos.js carregado e executando...");

  // Atualiza todos os contadores existentes
  const campos = document.querySelectorAll(".campo-com-contador input[type='text']");

  campos.forEach(function (campo) {
    const contador = campo.parentElement.querySelector(".caracteres");
    atualizarContador(campo, contador);
    campo.addEventListener("input", function () {
      atualizarContador(campo, contador);
      validarCamposInclusao(); // Atualiza botão a cada digitação
    });
  });

  /**
   * Atualiza o contador de caracteres
   */
  function atualizarContador(campo, contador) {
    const max = campo.getAttribute("maxlength");
    const atual = campo.value.length;
    const atualFormatado = atual.toString().padStart(3, '0');
    contador.textContent = `${atualFormatado}/${max}`;
  }

  /**
   * Valida campos da inclusão e ativa/desativa botão
   */
  function validarCamposInclusao() {
  const nomeInput = document.querySelector('input[name="novo_nome"]');
  const urlInput = document.querySelector('input[name="novo_url"]');
  const btnAdicionar = document.querySelector('input[name="adicionar"]');

  if (!nomeInput || !urlInput || !btnAdicionar) return;

  const nome = nomeInput.value.trim();
  const url = urlInput.value.trim();

  let urlValida = false;
  try {
    const test = new URL(url);
    urlValida = test.protocol === "http:" || test.protocol === "https:";
  } catch (_) {
    urlValida = false;
  }

  const camposOk = nome.length > 0 && url.length > 0 && urlValida;
  btnAdicionar.disabled = !camposOk;
}



  validarCamposInclusao(); // Executa uma vez ao carregar
});

/**
 * Recarrega a lista de favoritos sem atualizar a página inteira.
 */
function refreshFavoritos() {
  const box = document.getElementById("box-favoritos");

  if (!box) return;

  box.innerHTML = "Atualizando...";

  fetch("php/carrega_favoritos.php")
    .then((res) => res.text())
    .then((html) => {
      box.innerHTML = html;
    })
    .catch((err) => {
      box.innerHTML = "<p>Erro ao atualizar favoritos.</p>";
      console.error("Erro ao carregar favoritos:", err);
    });
}

