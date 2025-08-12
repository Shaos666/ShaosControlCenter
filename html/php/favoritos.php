<?php
include 'conexao.php';

// 🕰️ Define fuso horário explicitamente no PHP
date_default_timezone_set('America/Sao_Paulo');

// Agora todas as funções de data/hora usam esse fuso:
$data = date('Y-m-d');
$hora = date('H:i:s');

$mensagem = '';

// Se formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $visivel = isset($_POST['visivel']) ? 1 : 0;
    $editar = isset($_POST['editar']) ? true : false;

    if ($editar && $nome && $url && $id) {
        $data_update = date('Y-m-d');
        $hora_update = date('H:i:s');

        $sql = "UPDATE favoritos 
                   SET nome = ?, url = ?, visivel = ?, data_update = ?, hora_update = ?
                 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissi", $nome, $url, $visivel, $data_update, $hora_update, $id);

        if ($stmt->execute()) {
            $mensagem = "✓ Registro atualizado com sucesso.";
        } else {
            $mensagem = "✗ Erro ao atualizar: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensagem = "✗ Preencha os campos e marque 'Editar' para atualizar.";
    }
}


// Verifica se houve submissão do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo'] ?? '');
    $url = trim($_POST['url'] ?? '');

    // Verifica se ambos os campos estão preenchidos
    if (!empty($titulo) && !empty($url)) {
        $data = date('Y-m-d');
        $hora = date('H:i:s');

        $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, visivel, data, hora, data_criacao, data_alteracao) VALUES (?, ?, 1, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $url, $data, $hora, "$data $hora", "$data $hora"]);

        // Redireciona para evitar reenvio
        header("Location: favoritos.php?msg=sucesso");
        exit;
    } else {
        $mensagem = '⚠️ Preencha todos os campos antes de salvar.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Favoritos</title>
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

        .mod-aux-id-favorito {
            font-size: 0.8em;
            color: #888;
            margin-left: 6px;
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
        }

        .mod-aux-contador {
            width: 40px;
            text-align: right;
            margin-right: 15px;
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

        .mod-aux-info-timestamp {
            font-size: 0.75em;
            text-align: center;
            color: #ccc;
            margin-top: 5px;
        }

        .mod-aux-datas {
            font-size: 12px;
            color: #aaa;
            margin-top: 10px;
            text-align: center;
        }

        .mod-aux-historico {
            line-height: 1.6em;
        }

        .mod-aux-input-box {
            width: 80%;
            max-width: 600px;
        }

        .mod-aux-bloco-salvar {
            margin-top: 10px;
            text-align: center;
            padding: 8px;
            border-top: 1px solid #555;
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
            <button class="tab-btn <?= empty($_POST['acao']) ? 'active' : '' ?>" data-target="aba-editar">Editar</button>
            <button class="tab-btn <?= ($_POST['acao'] ?? '') === 'incluir' ? 'active' : '' ?>" data-target="aba-incluir">Incluir</button>
            <button class="tab-btn" data-target="aba-historico">Histórico</button>
        </div>

        <!-- EDITAR -->
        <div id="aba-editar" class="aba <?= empty($_POST['acao']) ? 'active' : '' ?>">
            <?php
            $sql = "SELECT * FROM favoritos ORDER BY id ASC LIMIT 50";
            $res = $conn->query($sql);
            foreach ($res as $row):
                $id = $row['id'];
                $nome = htmlspecialchars($row['nome']);
                $url = htmlspecialchars($row['url']);
                $visivel = $row['visivel'] == 1 ? 'checked' : '';
                $data = $row['data'];
                $hora = $row['hora'];
                $dataCriacao = $row['data_criacao'];
                $dataAlteracao = $row['data_alteracao'];
            ?>
                <div class="mod-aux-box">
                    <span class="mod-aux-id-favorito"><?= str_pad($id, 3, '0', STR_PAD_LEFT) ?></span>
                    <div class="mod-aux-linha">
                        <label>Título:</label>
                        <input type="text" value="<?= $nome ?>" class="mod-aux-input" oninput="atualizarContador(this)">
                        <div class="mod-aux-contador"><?= str_pad(strlen($nome), 3, '0', STR_PAD_LEFT) ?></div>
                        <label style="margin-left: 10px;"><input type="checkbox" <?= $visivel ?>> Visível</label>
                    </div>
                    <div class="mod-aux-linha">
                        <label>URL:</label>
                        <input type="text" value="<?= $url ?>" class="mod-aux-input" oninput="atualizarContador(this)">
                        <div class="mod-aux-contador"><?= str_pad(strlen($url), 3, '0', STR_PAD_LEFT) ?></div>
                        <label style="margin-left: 10px;"><input type="checkbox"> Editar</label>
                    </div>
                    <div class="mod-aux-info-timestamp">
                        Inclusão: <?= $dataCriacao ?> ——#—— Atualizado: <?= $dataAlteracao ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="mod-aux-bloco-salvar">
                <div class="mod-aux-save">
                    <button type="submit">Salvar</button>
                </div>
            </div>

        </div>

        <!-- INCLUIR -->
        <div id="aba-incluir" class="aba <?= ($_POST['acao'] ?? '') === 'incluir' ? 'active' : '' ?>">
            <?php if ($mensagem): ?>
                <div style="color:#00ff66; margin-bottom:10px;"><?= $mensagem ?></div>
            <?php endif; ?>
            <form method="POST" autocomplete="off">
                <input type="hidden" name="acao" value="incluir">
                <div class="mod-aux-box">
                    <div class="mod-aux-linha">
                        <label for="titulo-new">Título:</label>
                        <input type="text" name="titulo" id="titulo-new" class="mod-aux-input" maxlength="100"
                            value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                            oninput="atualizarContador(this)">
                        <div class="mod-aux-contador" id="cont-titulo-new">
                            <?= str_pad(strlen($_POST['titulo'] ?? ''), 3, '0', STR_PAD_LEFT) ?>
                        </div>
                    </div>
                    <div class="mod-aux-linha">
                        <label for="url-new">URL:</label>
                        <input type="text" name="url" id="url-new" class="mod-aux-input" maxlength="255"
                            value="<?= htmlspecialchars($_POST['url'] ?? '') ?>"
                            oninput="atualizarContador(this)">
                        <div class="mod-aux-contador" id="cont-url-new">
                            <?= str_pad(strlen($_POST['url'] ?? ''), 3, '0', STR_PAD_LEFT) ?>
                        </div>
                    </div>
                    <div class="mod-aux-save">
                        <button type="submit">Salvar</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- HISTÓRICO -->
        <div id="aba-historico" class="aba">
            <div class="mod-aux-box mod-aux-historico">
                <h2>Histórico e Relatórios</h2>
                <?php
                $total = $conn->query("SELECT COUNT(*) FROM favoritos")->fetchColumn();
                $ult_insert = $conn->query("SELECT MAX(data_criacao) FROM favoritos")->fetchColumn();
                $ult_update = $conn->query("SELECT MAX(data_alteracao) FROM favoritos")->fetchColumn();
                $ocultos = $conn->query("SELECT COUNT(*) FROM favoritos WHERE visivel = 0")->fetchColumn();
                ?>
                <p>Último INSERT: <?= $ult_insert ?></p>
                <p>Último UPDATE: <?= $ult_update ?></p>
                <p>Total de registros: <?= $total ?></p>
                <p>Favoritos Ocultos: <?= $ocultos ?></p>
                <h3>Estrutura da Tabela</h3>
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