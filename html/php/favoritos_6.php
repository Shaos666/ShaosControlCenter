<?php
include_once "conexao.php";

// Inserção de novo favorito
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["adicionar"])) {
    $nome = substr(trim($_POST["novo_nome"] ?? ''), 0, 100);
    $url = substr(trim($_POST["novo_url"] ?? ''), 0, 255);
    $data = date("Y-m-d");
    $hora = date("H:i:s");
    if ($nome !== "" && $url !== "") {
        $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, data, hora, visivel, data_criacao, data_alteracao) VALUES (?, ?, ?, ?, 1, NOW(), NOW())");
        $stmt->execute([$nome, $url, $data, $hora]);
    }
    echo "<script>window.opener?.recarregarFavoritosBox?.();</script>";
}

// Atualização dos favoritos
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["salvar_edicoes"])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, "editar_") === 0) {
            $id = str_replace("editar_", "", $key);
            $nome = $_POST["nome_{$id}"] ?? '';
            $url = $_POST["url_{$id}"] ?? '';
            $visivel = isset($_POST["visivel_{$id}"]) ? 1 : 0;
            $stmt = $conn->prepare("UPDATE favoritos SET nome = ?, url = ?, visivel = ?, data_update = CURDATE(), hora_update = CURTIME(), data_alteracao = NOW() WHERE id = ?");
            $stmt->execute([$nome, $url, $visivel, $id]);
        }
    }
    echo "<script>window.opener?.recarregarFavoritosBox?.();</script>";
}

// Puxa todos os registros atualizados
$sql = "SELECT * FROM favoritos ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Favoritos</title>
    <style>
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

        .auxiliar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed #0f0;
            margin-bottom: 10px;
        }

        .auxiliar-tablinks {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .auxiliar-tablink {
            padding: 5px 15px;
            background: transparent;
            border: 1px solid #0f0;
            color: #0f0;
            cursor: pointer;
        }

        .auxiliar-tablink.active {
            background-color: #0f0;
            color: #000;
        }

        .auxiliar-tabcontent {
            display: none;
        }

        .auxiliar-tabcontent.active {
            display: block;
            border: 1px dotted #0f0;
            padding: 15px;
        }

        #auxiliar-lista-favoritos {
            max-height: 380px;
            /* ou ajuste como preferir */
            overflow-y: auto;
            padding-right: 6px;
            /* espaço para não cortar o conteúdo com a barra */
        }

        .auxiliar-lista-titulo {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .auxiliar-item {
            border: 1px solid #00ff00;
            padding: 8px;
            margin-bottom: 10px;
            color: #00ff00;
            font-family: monospace;
            /*            
            border: 1px solid #0f0;
            padding: 10px;
            margin-bottom: 10px;
*/
        }

        .auxiliar-item label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .auxiliar-item label input[type="text"] {
            flex: 1;
            /*
            width: 70%;
            */
            min-width: 60%;
            max-width: 60%;
            padding: 2px 6px;
        }

        .auxiliar-contador {
            font-size: 13px;
            color: #00ff00;
            min-width: 38px;
            text-align: right;
            padding-left: 4px;
            /*            
            width: 40px;
            text-align: right;
            font-size: 12px;
            
            font-size: 12px;
            float: right;
            */
        }

        .auxiliar-item input[type="checkbox"] {
            margin-left: auto;
            transform: scale(1.1);
        }

        .linha-info {
            text-align: center;
            font-size: 13px;
            color: #00ff00;
            margin-top: 8px;
        }

        .auxiliar-linha-pontilhada {
            display: none;
            /* remove a linha separadora */
            /*
            border-bottom: 1px dotted #0f0;
            margin: 10px 0;
            */
        }

        .bloco-favorito {
            border: 1px solid #00ff66;
            padding: 10px;
            margin-bottom: 20px;
            color: #00ff66;
            font-family: monospace;
        }


        .auxiliar-botao {
            background: transparent;
            border: 1px solid #0f0;
            color: #0f0;
            padding: 5px 10px;
            margin-top: 10px;
            cursor: pointer;
        }

        .auxiliar-input-nome {
            width: 400px;
            padding: 5px 10px;
            background: black;
            color: #00ff66;
            border: 1px solid #00ff66;
            font-family: monospace;
        }


        .info-extra label {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        input[type="text"] {
            width: 70%;
            background: #000;
            color: #0f0;
            border: 1px solid #0f0;
            padding: 5px;

            .linha-campo {
                display: flex;
                align-items: center;
                /*justify-content: flex-start;*/
                gap: 10px;
                margin-bottom: 5px;
                /*10px;*/
            }

            .campo-label {
                width: 60px;
                text-align: right;
                flex-shrink: 0;

                /*                
                width: 80px;
                text-align: right;
                font-weight: bold;
                flex-shrink: 0;
*/
            }

            .campo-input {
                flex: 1;
                max-width: 500px;
                padding: 5px 8px;
                background: black;
                color: #00ff66;
                border: 1px solid #00ff66;
                /*
                flex: 1;
                max-width: 350px;
                padding: 5px 8px;
                */
            }

            .info-extra {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 100px;
                justify-content: flex-end;
                white-space: nowrap;
            }

            .check-label {
                display: flex;
                align-items: center;
                gap: 5px;
                min-width: 100px;
            }

            .linha-status {
                text-align: center;
                margin-top: 8px;
                font-size: 13px;
            }

            .contador {
                width: 40px;
                text-align: right;
                /*                
                font-family: monospace;
                font-size: 16px;
                color: #00ff66;
*/
            }

            input[type="checkbox"] {
                transform: scale(1.2);
            }


        }
    </style>
</head>

<body>
    <header class="auxiliar-header">
        <h1>Gerenciamento de Favoritos</h1>
        <button class="auxiliar-botao" onclick="window.close()">⮐ Voltar</button>
    </header>
    <main>
        <div class="auxiliar-tablinks">
            <button class="auxiliar-tablink active" onclick="abrirAba(event, 'editar')">Editar</button>
            <button class="auxiliar-tablink" onclick="abrirAba(event, 'incluir')">Incluir</button>
            <button class="auxiliar-tablink" onclick="abrirAba(event, 'historico')">Histórico</button>
        </div>

        <!-- ABA EDITAR -->
        <div id="editar" class="auxiliar-tabcontent active">
            <form method="POST">
                <div class="auxiliar-lista-titulo">Lista de Favoritos</div>

                <!-- NOVO CONTAINER COM SCROLL -->
                <div id="auxiliar-lista-favoritos">
                    <?php foreach ($favoritos as $fav): ?>
                        <div class="auxiliar-item">
                            <div>ID: <?= str_pad($fav['id'], 3, '0', STR_PAD_LEFT) ?></div>

                            <div class="bloco-favorito">
                                <div class="linha-campo">
                                    <label class="campo-label" for="nome_<?= $fav['id'] ?>">Título:</label>
                                    <input type="text" id="nome_<?= $fav['id'] ?>" class="auxiliar-input-nome" name="nome_<?= $fav['id'] ?>" value="<?= htmlspecialchars($fav['nome']) ?>" maxlength="100" class="campo-input" oninput="atualizarContador(this, 'contador_nome_<?= $fav['id'] ?>')">
                                    <span id="contador_nome_<?= $fav['id'] ?>" class="contador"><?= str_pad(strlen($fav['nome']), 3, '0', STR_PAD_LEFT); ?></span>
                                    <label class="check-label"><input type="checkbox" name="visivel_<?= $fav['id'] ?>" <?= ($fav['visivel']) ? 'checked' : '' ?>> Visível</label>
                                </div>

                                <div class="linha-campo">
                                    <label class="campo-label" for="url_<?= $fav['id'] ?>">URL:</label>
                                    <input type="text" id="url_<?= $fav['id'] ?>" name="url_<?= $fav['id'] ?>" value="<?= htmlspecialchars($fav['url']) ?>" maxlength="255" class="campo-input" oninput="atualizarContador(this, 'contador_url_<?= $fav['id'] ?>')">
                                    <span id="contador_url_<?= $fav['id'] ?>" class="contador"><?= str_pad(strlen($fav['url']), 3, '0', STR_PAD_LEFT); ?></span>
                                    <label class="check-label"><input type="checkbox" name="editar_<?= $fav['id'] ?>"> Editar</label>
                                </div>


                            </div>
                            <div class="linha-info">
                                Inclusão: <?= $fav['data'] . ' ' . $fav['hora'] ?>
                                —#—
                                Atualizado: <?= $fav['data_update'] . ' ' . $fav['hora_update'] ?>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div> <!-- FIM DO CONTAINER COM SCROLL -->

                <button class="auxiliar-botao" type="submit" name="salvar_edicoes" onclick="setTimeout(recarregarFavoritosBox, 300);">Salvar Alterações</button>
            </form>
        </div>


        <!-- ABA INCLUIR -->
        <div id="incluir" class="auxiliar-tabcontent">
            <form method="POST">
                <h2>Incluir Novo Favorito</h2>
                <label>Título <span class="auxiliar-contador">000</span>
                    <input type="text" name="novo_nome" maxlength="100">
                </label>
                <label>URL <span class="auxiliar-contador">000</span>
                    <input type="text" name="novo_url" maxlength="255">
                </label>
                <button class="auxiliar-botao" type="submit" name="adicionar" onclick="setTimeout(recarregarFavoritosBox, 300);">Adicionar</button>
            </form>
        </div>

        <!-- ABA HISTÓRICO -->
        <div id="historico" class="auxiliar-tabcontent">
            <h2>Histórico e Relatórios</h2>
            <p>Total de registros: <?= count($favoritos) ?></p>
            <br>
            <h3>Estrutura da Tabela <code>favoritos</code>:</h3>
            <ul>
                <li><strong>id</strong>: int(11) [AUTO_INCREMENT]</li>
                <li><strong>nome</strong>: varchar(100) NULL</li>
                <li><strong>url</strong>: varchar(255)</li>
                <li><strong>data</strong>: date NULL [curdate()]</li>
                <li><strong>hora</strong>: time NULL [curtime()]</li>
                <li><strong>visivel</strong>: tinyint(1) NULL [1]</li>
                <li><strong>data_update</strong>: date NULL [curdate()]</li>
                <li><strong>hora_update</strong>: time NULL [curtime()]</li>
                <li><strong>data_criacao</strong>: datetime NULL [current_timestamp()]</li>
                <li><strong>data_alteracao</strong>: datetime NULL [current_timestamp()]</li>
            </ul>
        </div>
    </main>
    <footer>
        <p style="text-align:center; padding:10px;">Matrix Control • 2025</p>
    </footer>
    <script>
        function abrirAba(evt, nomeAba) {
            const tabs = document.querySelectorAll(".auxiliar-tabcontent");
            const links = document.querySelectorAll(".auxiliar-tablink");
            tabs.forEach(tab => tab.classList.remove("active"));
            links.forEach(btn => btn.classList.remove("active"));
            document.getElementById(nomeAba).classList.add("active");
            evt.currentTarget.classList.add("active");
        }

        // Contador de caracteres ativo nos campos de texto
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("input[type='text']").forEach(input => {
                const contador = input.parentElement.querySelector(".auxiliar-contador");
                if (contador) {
                    const atualizar = () => contador.textContent = input.value.length.toString().padStart(3, '0');
                    input.addEventListener("input", atualizar);
                    atualizar();
                }
            });
        });

        // Função para atualizar o contador de caracteres
        function atualizarContador(input, idContador) {
            document.getElementById(idContador).textContent = input.value.length.toString().padStart(3, '0');
        }


        // Refresh no box de favoritos
        function recarregarFavoritosBox() {
            fetch("php/carrega_favoritos.php")
                .then(resp => resp.text())
                .then(html => {
                    const box = window.opener?.document.getElementById("box-favoritos");
                    if (box) box.innerHTML = html;
                });
        }
    </script>
</body>

</html>