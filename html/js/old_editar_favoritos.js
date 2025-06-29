const nomesExistentes = window.nomesExistentes || [];

function atualizaContador(input, max) {
    const contador = input.nextElementSibling;
    const len = input.value.length;
    contador.textContent = String(len).padStart(3, '0');
    if (len > max) {
        contador.classList.add("excedido");
    } else {
        contador.classList.remove("excedido");
    }
}

function validarNovo() {
    const nome = document.getElementById("novo_nome").value.trim();
    const url = document.getElementById("novo_url").value.trim();
    const avisoNome = document.getElementById("aviso_nome");
    const avisoUrl = document.getElementById("aviso_url");
    avisoNome.textContent = "";
    avisoUrl.textContent = "";

    if (nomesExistentes.includes(nome.toLowerCase())) {
        avisoNome.textContent = "⚠️ Nome já existente!";
        return false;
    }

    if (!(url.startsWith("http://") || url.startsWith("https://"))) {
        avisoUrl.textContent = "⚠️ Link inválido (http:// ou https:// obrigatório)";
        return false;
    }

    return true;
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[type="text"]').forEach(input => {
        const max = input.getAttribute("maxlength") || 255;
        input.addEventListener("input", () => atualizaContador(input, max));
        atualizaContador(input, max);
    });

    // Somente validação do formulário novo
    const formNovo = document.querySelector("form[action='']"); // ajuste se necessário
    if (formNovo) {
        formNovo.onsubmit = validarNovo;
    }

    // Nada relacionado a checkboxes está sendo manipulado aqui!
});

