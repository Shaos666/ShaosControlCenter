<?php
include_once __DIR__ . '/conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["atualizar"])) {
    if (isset($_POST["id"])) {
        for ($i = 0; $i < count($_POST["id"]); $i++) {
            $id = intval($_POST["id"][$i]);
            $nome = substr($_POST["nome"][$i], 0, 100);
            $url = substr($_POST["url"][$i], 0, 255);
            $visivel = isset($_POST["visivel_check"][$id]) ? 1 : 0;
            $stmt = $conn->prepare("UPDATE favoritos SET nome = ?, url = ?, visivel = ? WHERE id = ?");
            $stmt->execute([$nome, $url, $visivel, $id]);
        }
        echo "<p style='color: #0f0; font-family: monospace;'>Atualização realizada com sucesso!</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["novo_nome"])) {
    $novo_nome = substr($_POST["novo_nome"], 0, 100);
    $novo_url = substr($_POST["novo_url"], 0, 255);
    $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, data, hora, visivel) VALUES (?, ?, CURDATE(), CURTIME(), 1)");
    $stmt->execute([$novo_nome, $novo_url]);
}

$stmt = $conn->prepare("SELECT * FROM favoritos ORDER BY nome ASC");
$stmt->execute();
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nomes_existentes = array_map(fn($fav) => strtolower($fav['nome']), $favoritos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Favoritos</title>
    <link rel="stylesheet" href="../css/editar_favoritos.css">
    <script>
      window.nomesExistentes = <?= json_encode($nomes_existentes) ?>;
    </script>
    <script src="../js/editar_favoritos.js" defer></script>
</head>
<body>

<div class="caixa editar-favoritos">
    <h2>Editar Favoritos</h2>
    <form method="POST">
        <?php foreach ($favoritos as $fav): ?>
            <div class="linha">
                <input type="hidden" name="id[]" value="<?= $fav['id'] ?>">
                <span class="id-label"><?= str_pad($fav['id'], 3, '0', STR_PAD_LEFT) ?></span>
                <div class="campo-com-contador">
                    <input type="text" name="nome[]" ...>
                    <span class="caracteres">000</span>
                </div>

                <input type="text" name="url[]" value="<?= htmlspecialchars($fav['url']) ?>" maxlength="255" oninput="atualizaContador(this, 255)">
                <span class="caracteres">000</span>
                <label class="visivel-box">
                    <input type="hidden" name="visivel_check[<?= $fav['id'] ?>]" value="0">
                    <input type="checkbox" name="visivel_check[<?= $fav['id'] ?>]" value="1" <?= $fav['visivel'] == 1 ? 'checked' : '' ?>>
                    Visível
                </label>
            </div>
        <?php endforeach; ?>
        <div class="centralizar">
          <input type="submit" name="atualizar" value="Salvar Alterações">
        </div>
    </form>
</div>

<div class="caixa adicionar-favorito">
    <h3>Adicionar Novo Favorito</h3>
    <form method="POST" onsubmit="return validarNovo()">
        <div class="linha">
            <input type="text" name="novo_nome" id="novo_nome" placeholder="Nome" maxlength="100" oninput="atualizaContador(this, 100)">
            <span class="caracteres" id="cont_nome">000</span>
        </div>
        <div class="linha">
            <input type="text" name="novo_url" id="novo_url" placeholder="https://..." maxlength="255" oninput="atualizaContador(this, 255)">
            <span class="caracteres" id="cont_url">000</span>
        </div>
        <div class="alerta" id="aviso_nome"></div>
        <div class="alerta" id="aviso_url"></div>
        <div class="centralizar">
          <input type="submit" value="Adicionar">
        </div>
    </form>
</div>

</body>
</html>

