// favoritos.js - Script personalizado para gerenciamento dos campos de texto com contador
// Criado por Shaos e FoxTrot em 2025

// Aguarda o carregamento completo do DOM
document.addEventListener("DOMContentLoaded", function () {

  // Seleciona todos os campos de texto que estão dentro de .campo-com-contador
  const campos = document.querySelectorAll(".campo-com-contador input[type='text']");

  // Para cada campo encontrado, aplica as funções abaixo
  campos.forEach(function (campo) {

    // Localiza o contador de caracteres ao lado do campo
    const contador = campo.parentElement.querySelector(".caracteres");

    // Atualiza o contador assim que a página carregar
    atualizarContador(campo, contador);

    // Escuta as mudanças no campo enquanto o usuário digita
    campo.addEventListener("input", function () {
      atualizarContador(campo, contador);
    });
  });

  /**
   * Função que atualiza o contador de caracteres ao lado do campo
   * @param {HTMLInputElement} campo - O campo de texto observado
   * @param {HTMLElement} contador - O elemento <span> onde o contador será exibido
   */
  function atualizarContador(campo, contador) {
    const max = campo.getAttribute("maxlength");   // Obtém o número máximo permitido
    const atual = campo.value.length;              // Conta os caracteres digitados
    contador.textContent = `${atual}/${max}`;      // Atualiza o contador na tela
  }
});

