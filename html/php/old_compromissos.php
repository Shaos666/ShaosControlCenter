<?php
include_once __DIR__ . '/conexao.php';
date_default_timezone_set('America/Sao_Paulo');

// Inserção de novo compromisso
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["adicionar"])) {
    $semana = intval($_POST["semana"]);
    $hora_bruta = trim($_POST["hora"]);
    $hora = strlen($hora_bruta) === 5 ? $hora_bruta . ':00' : $hora_bruta;
    $evento = substr(trim($_POST["evento"]), 0, 255);

    $stmt = $conn->prepare("INSERT INTO compromissos (semana, hora, evento) VALUES (?, ?, ?)");
    $stmt->execute([$semana, $hora, $evento]);

    header("Location: compromissos.php");
    exit;
}

// Alteração de compromissos existentes
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["atualizar"]) &&
    !empty($_POST["id"]) &&
    is_array($_POST["id"])
) {
    foreach ($_POST["id"] as $index => $id) {
        $id = intval($id);

        if (isset($_POST["editar"][$id])) {
            $semana = intval($_POST["semana"][$index]);
            $hora_bruta = trim($_POST["hora"][$index]);
            $hora = strlen($hora_bruta) === 5 ? $hora_bruta . ':00' : $hora_bruta;
            $evento = substr(trim($_POST["evento"][$index]), 0, 255);

            $stmt = $conn->prepare("UPDATE compromissos SET semana = ?, hora = ?, evento = ? WHERE id = ?");
            $stmt->execute([$semana, $hora, $evento, $id]);
        }
    }

    header("Location: compromissos.php");
    exit;
}

// Carregamento dos compromissos
$stmt = $conn->prepare("SELECT * FROM compromissos ORDER BY semana ASC, hora ASC");
$stmt->execute();
$compromissos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mapeamento de dias
$dias_semana = [
    1 => 'Domingo',
    2 => 'Segunda',
    3 => 'Terça',
    4 => 'Quarta',
    5 => 'Quinta',
    6 => 'Sexta',
    7 => 'Sábado'
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Compromissos</title>
  <link rel="stylesheet" href="../css/compromissos.css">
  <script src="../js/compromissos.js"></script>
</head>
<body>

<div class="centralizar">
    <a href="#" onclick="window.close();" class="botao-voltar">⏎ Voltar</a>
</div>

<h1>COMPROMISSOS</h1>

<!-- LISTAGEM -->
<div class="box box-edicao">
  <h2>Agenda da Semana</h2>
  <form method="POST">
    <div class="scroll-area">
      <?php foreach ($compromissos as $comp): ?>
        <div class="linha-registro">
          <div class="linha linha-editavel">
            <input type="hidden" name="id[]" value="<?= $comp['id'] ?>">
            <span class="id-label"><?= str_pad($comp['id'], 3, '0', STR_PAD_LEFT) ?></span>

            <select name="semana[]">
              <?php foreach ($dias_semana as $num => $nome): ?>
                <option value="<?= $num ?>" <?= $comp['semana'] == $num ? 'selected' : '' ?>><?= $nome ?></option>
              <?php endforeach; ?>
            </select>

            <input type="time" name="hora[]" value="<?= substr($comp['hora'], 0, 5) ?>">
            <input type="text" name="evento[]" value="<?= htmlspecialchars($comp['evento']) ?>" maxlength="255">

            <label class="check">
              <input type="checkbox" name="editar[<?= $comp['id'] ?>]"> Alterar
            </label>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="centralizar">
      <input type="submit" name="atualizar" value="Salvar Alterações">
    </div>
  </form>
</div>

<!-- INCLUSÃO -->
<div class="linha-box-secundario">
  <div class="box box-adicao">
    <h2>Novo Compromisso</h2>
    <form method="POST">
      <select name="semana">
        <?php foreach ($dias_semana as $num => $nome): ?>
          <option value="<?= $num ?>"><?= $nome ?></option>
        <?php endforeach; ?>
      </select>

      <input type="time" name="hora" placeholder="HH:MM">
      <input type="text" name="evento" placeholder="Descrição do evento" maxlength="255">

      <div class="centralizar">
        <input type="submit" name="adicionar" value="Adicionar">
      </div>
    </form>
  </div>

  <div class="box box-reserva">
    <h2>[RESERVA]</h2>
    <p>Espaço para recursos futuros.</p>
  </div>
</div>

</body>
</html>

