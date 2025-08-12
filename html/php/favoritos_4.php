<?php
include_once "php/conexao.php";

// Incluir novo favorito
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["adicionar"])) {
    $nome = substr(trim($_POST["novo_nome"]), 0, 100);
    $url = substr(trim($_POST["novo_url"]), 0, 255);
    $data = date("Y-m-d");
    $hora = date("H:i:s");

    if ($nome !== "" && $url !== "") {
        $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, data, hora, visivel, data_criacao, data_alteracao) VALUES (?, ?, ?, ?, 1, NOW(), NOW())");
        $stmt->execute([$nome, $url, $data, $hora]);
    }
}

// Atualizar favoritos existentes
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["salvar_edicoes"])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, "editar_") === 0) {
            $id = str_replace("editar_", "", $key);

            $nome = $_POST["nome_$id"] ?? '';
            $url = $_POST["url_$id"] ?? '';
            $visivel = isset($_POST["visivel_$id"]) ? 1 : 0;

            $stmt = $conn->prepare("UPDATE favoritos SET nome = ?, url = ?, visivel = ?, data_update = CURDATE(), hora_update = CURTIME(), data_alteracao = NOW() WHERE id = ?");
            $stmt->execute([$nome, $url, $visivel, $id]);
        }
    }
}

// Puxar favoritos atualizados
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
            <form method="POST" action="php/salvar_favoritos.php">
                <div class="auxiliar_lista_titulo">Lista de Favoritos</div>
                <?php
                $sql = "SELECT * FROM favoritos ORDER BY id ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($favoritos as $fav): ?>
                    <div class="auxiliar_item">
                        <div>ID: <?= str_pad($fav['id'], 3, '0', STR_PAD_LEFT) ?></div>
                        <label>Título
                            <span class="auxiliar_contador">000</span>
                            <input type="text" name="nome_<?= $fav['id'] ?>" value="<?= htmlspecialchars($fav['nome']) ?>" maxlength="100">
                        </label>
                        <label>URL
                            <span class="auxiliar_contador">000</span>
                            <input type="text" name="url_<?= $fav['id'] ?>" value="<?= htmlspecialchars($fav['url']) ?>" maxlength="255">
                        </label>
                        <label><input type="checkbox" name="visivel_<?= $fav['id'] ?>" <?= ($fav['visivel']) ? 'checked' : '' ?>> Visível</label>
                        <label><input type="checkbox" name="editar_<?= $fav['id'] ?>"> Editar</label>
                        <div>Inclusão: <?= $fav['data'] . ' ' . $fav['hora'] ?> —#— Atualizado: <?= $fav['data_update'] . ' ' . $fav['hora_update'] ?></div>
                        <div class="auxiliar_linha_pontilhada"></div>
                    </div>
                <?php endforeach; ?>
                <button class="auxiliar_botao" type="submit">Salvar Alterações</button>
            </form>
        </div>

        <!-- ABA INCLUIR -->
        <div id="incluir" class="auxiliar_tabcontent">
            <form method="POST" action="php/incluir_favorito.php">
                <h2>Incluir Novo Favorito</h2>
                <label>Título
                    <span class="auxiliar_contador">000</span>
                    <input type="text" name="novo_nome" maxlength="100">
                </label>
                <label>URL
                    <span class="auxiliar_contador">000</span>
                    <input type="text" name="novo_url" maxlength="255">
                </label>
                <button class="auxiliar_botao" type="submit" name="adicionar">Adicionar</button>
            </form>
        </div>

        <!-- ABA HISTÓRICO -->
        <div id="historico" class="auxiliar_tabcontent">
            <h2>Histórico e Relatórios</h2>
            <p>Último INSERT: 2025-08-03 22:47:19</p>
            <p>Último UPDATE: 2025-08-04 08:55:00</p>
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