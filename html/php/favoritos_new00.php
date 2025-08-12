<?php
// Arquivo: Favoritos_New00.php
// Local: /php/Favoritos_New00.php

include_once("conexao.php");
include_once("db.env.php");

// Consultas iniciais (resumidas para exibição)
$totalRegistros = 42;
$ultimoInsert = "2025-08-03 22:47:19";
$ultimoUpdate = "2025-08-04 08:55:00";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Favoritos - Controle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: #00ff66;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #003300;
            color: #00ff66;
            padding: 10px;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        button#btn-voltar {
            background-color: transparent;
            border: 1px solid #00ff66;
            color: #00ff66;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        main {
            padding: 20px;
        }

        .Mod-Aux-tabs button {
            background-color: #002200;
            color: #00ff66;
            border: 1px solid #00ff66;
            margin-right: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .Mod-Aux-tabcontent {
            display: none;
            margin-top: 20px;
        }

        .Mod-Aux-tabcontent.active {
            display: block;
        }

        .Mod-Aux-box {
            border: 1px solid #00ff66;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .Mod-Aux-linha {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .Mod-Aux-linha label {
            width: 60px;
        }

        .Mod-Aux-input {
            flex: 1;
            margin-right: 10px;
        }

        .Mod-Aux-input input {
            width: 100%;
            padding: 5px;
            background-color: #001100;
            border: 1px solid #00ff66;
            color: #00ff66;
        }

        .Mod-Aux-contador {
            width: 40px;
            text-align: right;
        }

        .Mod-Aux-checkbox {
            margin-left: 20px;
            display: flex;
            flex-direction: column;
        }

        .Mod-Aux-centralizado {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #66ff99;
        }

        footer {
            padding: 15px;
            text-align: center;
            border-top: 1px solid #00ff66;
        }

        .Mod-Aux-save {
            background-color: #003300;
            border: 1px solid #00ff66;
            color: #00ff66;
            padding: 8px 20px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <h1>
        Favoritos - Controle
        <button id="btn-voltar" onclick="window.history.back();">Voltar</button>
    </h1>
    <main>
        <div class="Mod-Aux-tabs">
            <button onclick="abrirAba('editar')">Editar</button>
            <button onclick="abrirAba('incluir')">Incluir</button>
            <button onclick="abrirAba('dados')">Histórico</button>
        </div>

        <div id="editar" class="Mod-Aux-tabcontent active">
            <!-- Exemplo de Box -->
            <div class="Mod-Aux-box">
                <div class="Mod-Aux-linha">
                    <label>Título:</label>
                    <div class="Mod-Aux-input"><input type="text" maxlength="100" oninput="atualizaContador(this)"></div>
                    <div class="Mod-Aux-contador">000</div>
                    <div class="Mod-Aux-checkbox">
                        <label><input type="checkbox"> Visível</label>
                        <label><input type="checkbox"> Editar</label>
                    </div>
                </div>
                <div class="Mod-Aux-linha">
                    <label>URL:</label>
                    <div class="Mod-Aux-input"><input type="text" maxlength="255" oninput="atualizaContador(this)"></div>
                    <div class="Mod-Aux-contador">000</div>
                </div>
                <div class="Mod-Aux-centralizado">
                    Incluído: 2025-08-01 15:30:00 — Atualizado: 2025-08-03 16:00:00
                </div>
            </div>
            <footer><button class="Mod-Aux-save">Salvar Alterações</button></footer>
        </div>

        <div id="incluir" class="Mod-Aux-tabcontent">
            <div class="Mod-Aux-box">
                <div class="Mod-Aux-linha">
                    <label>Título:</label>
                    <div class="Mod-Aux-input"><input type="text" maxlength="100" oninput="atualizaContador(this)"></div>
                    <div class="Mod-Aux-contador">000</div>
                </div>
                <div class="Mod-Aux-linha">
                    <label>URL:</label>
                    <div class="Mod-Aux-input"><input type="text" maxlength="255" oninput="atualizaContador(this)"></div>
                    <div class="Mod-Aux-contador">000</div>
                </div>
                <div class="Mod-Aux-centralizado">
                    <button class="Mod-Aux-save">Salvar Novo</button>
                </div>
            </div>
        </div>

        <div id="dados" class="Mod-Aux-tabcontent">
            <h2>Histórico e Relatórios</h2>
            <p>Último INSERT: <?php echo $ultimoInsert; ?></p>
            <p>Último UPDATE: <?php echo $ultimoUpdate; ?></p>
            <p>Total de registros: <?php echo $totalRegistros; ?></p>
            <p>Favoritos mais acessado:<br>→ título 1<br>→ título 2</p>
            <p>Últimas Ações:<br>→ Inserção de novo favorito<br>→ Atualização de título</p>
            <p>Favoritos Ocultos: Total 3<br>→ título oculto</p>
            <h3>Estrutura da Tabela</h3>
            <ul>
                <li>id: int(11) [auto_increment]</li>
                <li>nome: varchar(100)</li>
                <li>url: varchar(255)</li>
                <li>data: date</li>
                <li>hora: time</li>
                <li>visivel: tinyint(1)</li>
                <li>data_update: date</li>
                <li>hora_update: time</li>
                <li>data_criacao: datetime</li>
                <li>data_alteracao: datetime</li>
            </ul>
        </div>
    </main>

    <script>
        function abrirAba(id) {
            const tabs = document.querySelectorAll('.Mod-Aux-tabcontent');
            tabs.forEach(tab => tab.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }

        function atualizaContador(input) {
            const contador = input.parentElement.nextElementSibling;
            contador.textContent = input.value.length.toString().padStart(3, '0');
        }
    </script>
</body>

</html>