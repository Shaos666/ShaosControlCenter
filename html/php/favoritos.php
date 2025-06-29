<?php
include_once __DIR__ . '/conexao.php';

date_default_timezone_set('America/Sao_Paulo');

// Inserção de novo favorito
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["adicionar"])) {
    $novo_nome = substr($_POST["novo_nome"], 0, 100);
    $novo_url = substr($_POST["novo_url"], 0, 255);
    $data = date("Y-m-d");
    $hora = date("H:i:s");

    $stmt = $conn->prepare("INSERT INTO favoritos (nome, url, data, hora, visivel) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([$novo_nome, $novo_url, $data, $hora]);

    header("Location: favoritos.php");
    exit;
}

// Alteração de favoritos existentes
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["atualizar"]) &&
    !empty($_POST["id"]) &&
    is_array($_POST["id"])
) {
    foreach ($_POST["id"] as $index => $id) {
        $id = intval($id);

        if (isset($_POST["editar"][$id])) {
            $nome = substr($_POST["nome"][$index], 0, 100);
            $url = substr($_POST["url"][$index], 0, 255);
            $visivel = isset($_POST["visivel"][$id]) ? 1 : 0;
            $data_update = date("Y-m-d");
            $hora_update = date("H:i:s");

            $stmt = $conn->prepare("UPDATE favoritos 
                SET nome = ?, url = ?, visivel = ?, data_update = ?, hora_update = ? 
                WHERE id = ?");
            $stmt->execute([$nome, $url, $visivel, $data_update, $hora_update, $id]);
        }
    }

    header("Location: favoritos.php");
    exit;
}

// Carregar favoritos para exibição
$stmt = $conn->prepare("SELECT * FROM favoritos ORDER BY nome ASC");
$stmt->execute();
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Favoritos</title>
  <link rel="stylesheet" href="../css/favoritos.css">
  <script src="../js/favoritos.js"></script>
</head>
<body>

<div class="voltar-container">
  <button onclick="history.back()">⮐ Voltar</button>
</div>

<h1>FAVORITOS</h1>

<!-- BOX 01 – LISTAGEM -->
<div class="box box-edicao">
  <h2>Lista</h2>
  <form method="POST">
    <div class="scroll-area">
      <?php foreach ($favoritos as $fav): ?>
        <div class="linha-registro">
          <!-- Linha 01 – Editável -->
          <div class="linha linha-editavel">
            <input type="hidden" name="id[]" value="<?= $fav['id'] ?>">
            <span class="id-label"><?= str_pad($fav['id'], 3, '0', STR_PAD_LEFT) ?></span>

            <div class="campo-com-contador">
              <input type="text" name="nome[]" value="<?= htmlspecialchars($fav['nome']) ?>" maxlength="100">
              <span class="caracteres">000</span>
            </div>

            <div class="campo-com-contador">
              <input type="text" name="url[]" value="<?= htmlspecialchars($fav['url']) ?>" maxlength="255">
              <span class="caracteres">000</span>
            </div>

            <label class="check">
              <input type="checkbox" name="visivel[<?= $fav['id'] ?>]" <?= $fav['visivel'] ? 'checked' : '' ?>> Visível
            </label>

            <label class="check">
              <input type="checkbox" name="editar[<?= $fav['id'] ?>]"> Editar
            </label>
          </div>

          <!-- Linha 02 – Info -->
          <div class="linha linha-info">
            <span>Inclusão: <?= $fav['data'] ?> <?= $fav['hora'] ?></span>
            <span>Atualizado: <?= $fav['data_update'] ?? '-' ?> <?= $fav['hora_update'] ?? '-' ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="centralizar">
      <input type="submit" name="atualizar" value="Salvar Alterações">
    </div>
  </form>
</div>

<!-- BOX 02 – ADIÇÃO -->
<div class="linha-box-secundario">
  <div class="box box-adicao">
    <h2>Incluir Novo</h2>
    <form method="POST">
      <div class="campo-com-contador">
        <input type="text" name="novo_nome" placeholder="Título" maxlength="100">
        <span class="caracteres">000</span>
      </div>

      <div class="campo-com-contador">
        <input type="text" name="novo_url" placeholder="https://..." maxlength="255">
        <span class="caracteres">000</span>
      </div>

      <div class="centralizar">
        <input type="submit" name="adicionar" value="Adicionar">
      </div>
    </form>
  </div>

  <!-- RESERVA PARA BOX 03 -->
  <div class="box box-reserva">
    <h2>[RESERVA]</h2>
    <p>Futuro relatório e estatísticas...</p>
  </div>
</div>

</body>
</html>

