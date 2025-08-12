<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Favoritos</title>
    <style>
        /* ═══════════════════════════════════════
       THEME MATRIX - Estilo Auxiliar
       Todos os blocos iniciam com "auxiliar_"
       ═══════════════════════════════════════ */

        body {
            background-color: #000;
            color: #0f0;
            font-family: monospace;
            margin: 0;
            padding: 0;
        }

        header,
        main,
        footer {
            padding: 10px;
            margin: 0 auto;
            max-width: 900px;
        }

        .auxiliar_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed #0f0;
            margin-bottom: 10px;
        }

        .auxiliar_tablinks {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .auxiliar_tablink {
            padding: 5px 15px;
            background: transparent;
            border: 1px solid #0f0;
            color: #0f0;
            cursor: pointer;
        }

        .auxiliar_tablink.active {
            background-color: #0f0;
            color: #000;
        }

        .auxiliar_tabcontent {
            display: none;
        }

        .auxiliar_tabcontent.active {
            display: block;
            border: 1px dotted #0f0;
            padding: 15px;
        }

        .auxiliar_lista_titulo {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .auxiliar_item {
            border: 1px solid #0f0;
            padding: 10px;
            margin-bottom: 10px;
        }

        .auxiliar_contador {
            font-size: 12px;
            float: right;
        }

        .auxiliar_linha_pontilhada {
            border-bottom: 1px dotted #0f0;
            margin: 10px 0;
        }

        .auxiliar_botao {
            background: transparent;
            border: 1px solid #0f0;
            color: #0f0;
            padding: 5px 10px;
            margin-top: 10px;
            cursor: pointer;
        }

        input[type="text"] {
            width: 100%;
            background: #000;
            color: #0f0;
            border: 1px solid #0f0;
            padding: 5px;
        }
    </style>
</head>

<body>
    <header class="auxiliar_header">
        <h1>Gerenciamento de Favoritos</h1>
        <button class="auxiliar_botao" onclick="window.close()">⮐ Voltar</button>
    </header>

    <main>
        <div class="auxiliar_tablinks">
            <button class="auxiliar_tablink active" onclick="abrirAba(event, 'editar')">Editar</button>
            <button class="auxiliar_tablink" onclick="abrirAba(event, 'incluir')">Incluir</button>
            <button class="auxiliar_tablink" onclick="abrirAba(event, 'historico')">Histórico</button>
        </div>

        <!-- ABA EDITAR -->
        <div id="editar" class="auxiliar_tabcontent active">
            <div class="auxiliar_lista_titulo">Lista de Favoritos</div>
            <div class="auxiliar_item">
                <div>ID: 001</div>
                <label>Título
                    <span class="auxiliar_contador">000</span>
                    <input type="text" maxlength="100">
                </label>
                <label>URL
                    <span class="auxiliar_contador">000</span>
                    <input type="text" maxlength="255">
                </label>
                <label><input type="checkbox"> Visível</label>
                <label><input type="checkbox"> Editar</label>
                <div>Inclusão: 2025-08-01 12:00:00 —#— Atualizado: 2025-08-04 09:30:00</div>
                <div class="auxiliar_linha_pontilhada"></div>
            </div>
            <button class="auxiliar_botao">Salvar Alterações</button>
        </div>

        <!-- ABA INCLUIR -->
        <div id="incluir" class="auxiliar_tabcontent">
            <h2>Incluir Novo Favorito</h2>
            <label>Título
                <span class="auxiliar_contador">000</span>
                <input type="text" maxlength="100">
            </label>
            <label>URL
                <span class="auxiliar_contador">000</span>
                <input type="text" maxlength="255">
            </label>
            <button class="auxiliar_botao">Adicionar</button>
        </div>

        <!-- ABA HISTÓRICO -->
        <div id="historico" class="auxiliar_tabcontent">
            <h2>Histórico e Relatórios</h2>
            <p>Último INSERT: 2025-08-03 22:47:19</p>
            <p>Último UPDATE: 2025-08-04 08:55:00</p>
            <p>Total de registros: 42</p>
            <p>Favoritos mais acessados, últimas ações, favoritos ocultos...</p>
        </div>
    </main>

    <footer>
        <p style="text-align:center; padding:10px;">Matrix Control • 2025</p>
    </footer>

    <script>
        // Função de alternância entre abas
        function abrirAba(evt, nomeAba) {
            const tabs = document.querySelectorAll(".auxiliar_tabcontent");
            const links = document.querySelectorAll(".auxiliar_tablink");
            tabs.forEach(tab => tab.classList.remove("active"));
            links.forEach(btn => btn.classList.remove("active"));
            document.getElementById(nomeAba).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>

</html>