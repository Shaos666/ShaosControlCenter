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

        .mod-aux-box {
            border: 1px solid #00ff66;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .mod-aux-linha {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .mod-aux-linha label {
            width: 80px;
        }

        .mod-aux-input {
            flex: 1;
            margin-right: 10px;
            background-color: #001f00;
            color: #00ff66;
            border: 1px solid #00ff66;
            padding: 5px;
            outline: none;
            caret-color: #00ff66;
        }

        .mod-aux-input:focus {
            outline: auto;
            /*            
            border-color: #00ffff;
            box-shadow: 0 0 4px #00ffff;
*/

            border-color: #00cc66;
            box-shadow: 0 0 4px #00cc66;

        }



        .mod-aux-contador {
            width: 40px;
            text-align: right;
            margin-right: 15px;
        }

        .mod-aux-checkbox {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .mod-aux-datas {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 10px;
        }

        .mod-aux-scroll-area {
            max-height: 350px;
            overflow-y: auto;
            padding-right: 10px;
            border-right: 2px solid #00ff66;
        }

        .mod-aux-save {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .mod-aux-save button {
            background-color: #00ff66;
            color: black;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .mod-aux-historico {
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
            <div class="mod-aux-scroll-area">

                <?php
                include 'conexao.php';

                try {
                    $sql = "SELECT * FROM favoritos ORDER BY id ASC LIMIT 50";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($resultados) > 0):
                        foreach ($resultados as $row):
                            $id = $row['id'];
                            $nome = htmlspecialchars($row['nome']);
                            $url = htmlspecialchars($row['url']);
                            $visivel = $row['visivel'] == 1 ? 'checked' : '';
                            $data_inc = $row['data_criacao'] ?? $row['data'];
                            $hora_inc = $row['hora'] ?? '00:00:00';
                            $data_alt = $row['data_alteracao'] ?? $row['data_update'];
                            $hora_alt = $row['hora_update'] ?? '00:00:00';
                ?>
                            <div class="mod-aux-box">
                                <div class="mod-aux-linha">
                                    <label for="titulo<?= $id ?>">Título:</label>
                                    <input type="text" id="titulo<?= $id ?>" class="mod-aux-input" maxlength="100"
                                        value="<?= $nome ?>" oninput="atualizarContador(this)">
                                    <div class="mod-aux-contador" id="cont-titulo<?= $id ?>"><?= str_pad(strlen($nome), 3, '0', STR_PAD_LEFT) ?></div>
                                    <div style="margin-left: 10px; display: flex; gap: 15px;">
                                        <label style="display: inline-flex; align-items: center; gap: 5px;">
                                            <input type="checkbox" <?= $visivel ?>> Visível
                                        </label>
                                    </div>
                                </div>
                                <div class="mod-aux-linha">
                                    <label for="url<?= $id ?>">URL:</label>
                                    <input type="text" id="url<?= $id ?>" class="mod-aux-input" maxlength="255"
                                        value="<?= $url ?>" oninput="atualizarContador(this)">
                                    <div class="mod-aux-contador" id="cont-url<?= $id ?>"><?= str_pad(strlen($url), 3, '0', STR_PAD_LEFT) ?></div>
                                    <div style="margin-left: 10px; display: flex; gap: 15px;">
                                        <label style="display: inline-flex; align-items: center; gap: 5px;">
                                            <input type="checkbox"> Editar
                                        </label>
                                    </div>
                                </div>
                                <div class="mod-aux-datas">
                                    Incluído: <?= $data_inc . ' ' . $hora_inc ?> — Atualizado: <?= $data_alt . ' ' . $hora_alt ?>
                                </div>
                            </div>
                <?php
                        endforeach;
                    else:
                        echo "<p style='color:red;'>Nenhum registro encontrado na tabela favoritos.</p>";
                    endif;
                } catch (PDOException $e) {
                    echo "<p style='color:red;'>Erro ao consultar favoritos: " . $e->getMessage() . "</p>";
                }

                // Fechar conexão no PDO:
                $conn = null;
                ?>



            </div>
            <div class="mod-aux-save">
                <button onclick="alert('Salvar registros marcados para edição!')">Salvar</button>
            </div>
        </div>

        <div id="aba-incluir" class="aba">
            <div class="mod-aux-box">
                <div class="mod-aux-linha">
                    <label for="titulo-new">Título:</label>
                    <input type="text" id="titulo-new" class="mod-aux-input" maxlength="100" oninput="atualizarContador(this)">
                    <div class="mod-aux-contador" id="cont-titulo-new">000</div>
                </div>
                <div class="mod-aux-linha">
                    <label for="url-new">URL:</label>
                    <input type="text" id="url-new" class="mod-aux-input" maxlength="255" oninput="atualizarContador(this)">
                    <div class="mod-aux-contador" id="cont-url-new">000</div>
                </div>
                <div class="mod-aux-save">
                    <button onclick="alert('Inserir novo favorito')">Salvar</button>
                </div>
            </div>
        </div>

        <div id="aba-historico" class="aba">
            <div class="mod-aux-box mod-aux-historico">
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