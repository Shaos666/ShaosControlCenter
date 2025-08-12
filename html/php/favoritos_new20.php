<?php
// Arquivo: Favoritos_New00.php
// Caminho sugerido: /php/Favoritos_New00.php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Favoritos - Gerenciamento</title>
    <style>
        body {
            background-color: black;
            color: #00ff66;
            font-family: Consolas, monospace;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #111;
            color: #00ff66;
            margin: 0;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #00ff66;
        }

        button#voltar {
            background-color: #222;
            color: #00ff66;
            border: 1px solid #00ff66;
            padding: 6px 12px;
            cursor: pointer;
        }

        main {
            padding: 20px;
        }

        .aba-menu {
            display: flex;
            margin-bottom: 15px;
        }

        .aba-menu button {
            flex: 1;
            background-color: #111;
            border: 1px solid #00ff66;
            color: #00ff66;
            padding: 10px;
            cursor: pointer;
        }

        .aba-menu button.active {
            background-color: #00ff66;
            color: black;
            font-weight: bold;
        }

        .aba {
            display: none;
        }

        .aba.active {
            display: block;
        }

        .Mod-Aux-box {
            border: 1px solid #00ff66;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .Mod-Aux-linha {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .Mod-Aux-linha label {
            width: 80px;
        }

        .Mod-Aux-input {
            flex: 1;
            margin-right: 10px;
        }

        .Mod-Aux-contador {
            width: 40px;
            text-align: right;
            margin-right: 15px;
        }

        .Mod-Aux-checkbox {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .Mod-Aux-datas {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 10px;
        }

        .Mod-Aux-scroll-area {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
            border-right: 2px solid #00ff66;
        }

        .Mod-Aux-save {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .Mod-Aux-save button {
            background-color: #00ff66;
            color: black;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .Mod-Aux-historico {
            line-height: 1.6em;
        }

        footer {
            text-align: center;
            padding: 15px;
            font-size: 11px;
            color: #555;
            border-top: 1px solid #00ff66;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <h1>
        Favoritos - Gerenciamento
        <button id="voltar" onclick="window.history.back()">Voltar</button>
    </h1>

    <main>
        <div class="aba-menu">
            <button class="tab-btn active" data-target="aba-editar">Editar</button>
            <button class="tab-btn" data-target="aba-incluir">Incluir</button>
            <button class="tab-btn" data-target="aba-historico">Histórico</button>
        </div>

        <div id="aba-editar" class="aba active">
            <div class="Mod-Aux-scroll-area">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <div class="Mod-Aux-box">
                        <div class="Mod-Aux-linha">
                            <label for="titulo<?= $i ?>">Título:</label>
                            <input type="text" id="titulo<?= $i ?>" class="Mod-Aux-input" maxlength="100" oninput="atualizarContador(this)">
                            <div class="Mod-Aux-contador" id="cont-titulo<?= $i ?>">000</div>
                            <label style="margin-left: 10px;"><input type="checkbox"> Visível</label>
                        </div>
                        <div class="Mod-Aux-linha">
                            <label for="url<?= $i ?>">URL:</label>
                            <input type="text" id="url<?= $i ?>" class="Mod-Aux-input" maxlength="255" oninput="atualizarContador(this)">
                            <div class="Mod-Aux-contador" id="cont-url<?= $i ?>">000</div>
                            <label style="margin-left: 10px;"><input type="checkbox"> Editar</label>
                        </div>
                        <div class="Mod-Aux-datas">
                            Incluído: 2025-08-01 15:30:00 — Atualizado: 2025-08-03 16:00:00
                        </div>
                    </div>
                <?php endfor; ?>

            </div>
            <div class="Mod-Aux-save">
                <button onclick="alert('Salvar registros marcados para edição!')">Salvar</button>
            </div>
        </div>

        <div id="aba-incluir" class="aba">
            <div class="Mod-Aux-box">
                <div class="Mod-Aux-linha">
                    <label for="titulo-new">Título:</label>
                    <input type="text" id="titulo-new" class="Mod-Aux-input" maxlength="100" oninput="atualizarContador(this)">
                    <div class="Mod-Aux-contador" id="cont-titulo-new">000</div>
                </div>
                <div class="Mod-Aux-linha">
                    <label for="url-new">URL:</label>
                    <input type="text" id="url-new" class="Mod-Aux-input" maxlength="255" oninput="atualizarContador(this)">
                    <div class="Mod-Aux-contador" id="cont-url-new">000</div>
                </div>
                <div class="Mod-Aux-save">
                    <button onclick="alert('Inserir novo favorito')">Salvar</button>
                </div>
            </div>
        </div>

        <div id="aba-historico" class="aba">
            <div class="Mod-Aux-box Mod-Aux-historico">
                <h2>Histórico e Relatórios</h2>
                <p>Último INSERT: 2025-08-03 22:47:19</p>
                <p>Último UPDATE: 2025-08-04 08:55:00</p>
                <p>Total de registros: 42</p>
                <p>Favoritos mais acessados:</p>
                <ul>
                    <li>→ Google</li>
                    <li>→ GitHub</li>
                    <li>→ Obsidian</li>
                </ul>
                <p>Favoritos Ocultos: 4</p>
                <ul>
                    <li>→ Exemplo Oculto 1</li>
                    <li>→ Exemplo Oculto 2</li>
                </ul>
                <h3>Estrutura da Tabela: favoritos</h3>
                <ul>
                    <li>id — int(11) [auto_increment]</li>
                    <li>nome — varchar(100)</li>
                    <li>url — varchar(255)</li>
                    <li>data — date</li>
                    <li>hora — time</li>
                    <li>visivel — tinyint(1)</li>
                    <li>data_update — date</li>
                    <li>hora_update — time</li>
                    <li>data_criacao — datetime</li>
                    <li>data_alteracao — datetime</li>
                </ul>
            </div>
        </div>
    </main>

    <style>
        .color-demo-table {
            border-collapse: collapse;
            margin-top: 10px;
            font-family: Consolas, monospace;
        }

        .color-demo-table td {
            padding: 10px 20px;
            border: 1px solid #00ff66;
            color: #00ff66;
            font-size: 14px;
        }

        .color-sample {
            width: 180px;
            height: 30px;
            border: 1px solid #00ff66;
            padding: 4px;
            text-align: center;
        }
    </style>
    <table class="color-demo-table">
        <tr>
            <th>Cor</th>
            <th>HEX</th>
            <th>Exemplo Visual</th>
        </tr>
        <tr>
            <td>Verde Matrix Escuro</td>
            <td>#001f00</td>
            <td>
                <div class="color-sample" style="background-color:#001f00;">#001f00</div>
            </td>
        </tr>
        <tr>
            <td>Verde Matrix Claro</td>
            <td>#003300</td>
            <td>
                <div class="color-sample" style="background-color:#003300;">#003300</div>
            </td>
        </tr>
        <tr>
            <td>Preto translúcido</td>
            <td>rgba(0,0,0,0.6)</td>
            <td>
                <div class="color-sample" style="background-color:rgba(0,0,0,0.6);">rgba(0,0,0,0.6)</div>
            </td>
        </tr>
        <tr>
            <td>Cinza Futurista</td>
            <td>#1c1c1c</td>
            <td>
                <div class="color-sample" style="background-color:#1c1c1c;">#1c1c1c</div>
            </td>
        </tr>
        <tr>
            <td>Azul Profundo</td>
            <td>#001d3d</td>
            <td>
                <div class="color-sample" style="background-color:#001d3d;">#001d3d</div>
            </td>
        </tr>
    </table>

    <footer>
        FoxTrot Framework • SHAOS MATRIX SYSTEM • 2025
    </footer>

    <script>
        function atualizarContador(input) {
            const id = input.id;
            const contador = document.getElementById("cont-" + id);
            if (contador) {
                contador.innerText = input.value.length.toString().padStart(3, '0');
            }
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.aba').forEach(tab => tab.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
            });
        });
    </script>

</body>

</html>