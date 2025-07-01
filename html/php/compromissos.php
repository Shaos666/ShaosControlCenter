<?php
include_once __DIR__ . '/conexao.php';
date_default_timezone_set('America/Sao_Paulo');

// SALVAR ALTERAÇÕES
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
            $hora = $_POST["hora"][$index] . ":00"; // adiciona segundos
            $evento = substr(trim($_POST["evento"][$index]), 0, 255);

            $stmt = $conn->prepare("UPDATE compromissos 
                SET semana = ?, hora = ?, evento = ?
                WHERE id = ?");
            $stmt->execute([$semana, $hora, $evento, $id]);
        }
    }

    header("Location: compromissos.php");
    exit;
}

// CARREGA COMPROMISSOS
$stmt = $conn->prepare("SELECT * FROM compromissos ORDER BY semana ASC, hora ASC");
$stmt->execute();
$compromissos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nomes_dias = [
    1 => 'Domingo',
    2 => 'Segunda',
    3 => 'Terça',
    4 => 'Quarta',
    5 => 'Quinta',
    6 => 'Sexta',
    7 => 'Sábado'
];

// INSERÇÃO DE NOVO COMPROMISSO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["adicionar"])) {
    $semana = intval($_POST["novo_semana"]);
    $hora = $_POST["novo_hora"] . ":00"; // garante segundos
    $evento = substr(trim($_POST["novo_evento"]), 0, 255);

    $stmt = $conn->prepare("INSERT INTO compromissos (semana, hora, evento) VALUES (?, ?, ?)");
    $stmt->execute([$semana, $hora, $evento]);

    header("Location: compromissos.php");
    exit;
}

// ESTATÍSTICAS
$dias = [
  1 => "Domingo", 2 => "Segunda", 3 => "Terça",
  4 => "Quarta", 5 => "Quinta", 6 => "Sexta", 7 => "Sábado"
];

// Total
$stmt = $conn->query("SELECT COUNT(*) FROM compromissos");
$total_compromissos = $stmt->fetchColumn();

// Por dia da semana
$stmt = $conn->query("SELECT semana, COUNT(*) as qtd FROM compromissos GROUP BY semana ORDER BY semana");
$compromissos_por_dia = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $compromissos_por_dia[$row['semana']] = $row['qtd'];
}

// Último evento
$stmt = $conn->query("SELECT evento, hora FROM compromissos ORDER BY id DESC LIMIT 1");
$ultimo = $stmt->fetch(PDO::FETCH_ASSOC);
$ultimo_evento = $ultimo ? "{$ultimo['evento']} às {$ultimo['hora']}" : "Nenhum";


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Compromissos</title>
  <link rel="stylesheet" href="../css/matrix-theme.css">
  <script src="../js/abas.js"></script>
  <script src="../js/compromissos.js"></script>
</head>
<body>

<div class="centralizar">
    <a href="#" onclick="window.close();" class="botao-voltar">⏎ Voltar</a>
</div>

<h1>Gestão de Compromissos</h1>

<div class="menu-abas">
  <button class="aba-botao ativo" data-alvo="aba1">📋 Listagem e Atualizações</button>
  <button class="aba-botao" data-alvo="aba2">➕ Incluir Compromisso</button>
  <button class="aba-botao" data-alvo="aba3">📊 Estatísticas</button>
</div>

<div class="abas-container">
  <section id="aba1" class="aba-conteudo ativo">
    <!-- Conteúdo da aba 1 -->
<!-- ABA 01 - LISTAGEM E EDI├ç├âO -->
<div class="aba" id="aba1">
  <h2>­ƒôà Lista de Compromissos</h2>
  <form method="POST">
    <div class="box box-edicao">
      <div class="scroll-area">
        <?php foreach ($compromissos as $item): ?>
          <div class="linha-registro">
            <div class="linha linha-editavel">
              <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
              <span class="id-label"><?= str_pad($item['id'], 3, '0', STR_PAD_LEFT) ?></span>

              <select name="semana[]">
                <?php foreach ($dias as $num => $nome): ?>
                  <option value="<?= $num ?>" <?= $item['semana'] == $num ? 'selected' : '' ?>><?= $nome ?></option>
                <?php endforeach; ?>
              </select>

              <input type="time" name="hora[]" value="<?= substr($item['hora'], 0, 5) ?>">

              <div class="campo-com-contador">
                <input type="text" name="evento[]" value="<?= htmlspecialchars($item['evento']) ?>" maxlength="255">
                <span class="caracteres">000</span>
              </div>

              <label class="check">
                <input type="checkbox" name="editar[<?= $item['id'] ?>]"> Alterar
              </label>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="centralizar">
        <input type="submit" name="atualizar" value="Salvar Altera├º├Áes">
      </div>
    </div>
  </form>
</div>
  </section>
  <section id="aba2" class="aba-conteudo">
    <!-- Conteúdo da aba 2 -->
<!-- ABA 02 - INCLUS├âO -->
<div id="tab2" class="tab-content">
  <div class="box box-adicao">
    <h2>Incluir Compromisso</h2>
    <form method="POST" action="compromissos.php">
      <div class="campo">
        <label for="novo_semana">Dia da Semana:</label>
        <select name="novo_semana" id="novo_semana">
          <?php foreach ($nomes_dias as $key => $dia): ?>
            <option value="<?= $key ?>"><?= $dia ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="campo">
        <label for="novo_hora">Hora:</label>
        <input type="time" name="novo_hora" id="novo_hora" required>
      </div>

      <div class="campo-com-contador">
        <input type="text" name="novo_evento" placeholder="Descri├º├úo do evento" maxlength="255" required>
        <span class="caracteres">000</span>
      </div>

      <div class="centralizar">
        <input type="submit" name="adicionar" value="Adicionar">
      </div>
    </form>
  </div>
</div>
  </section>
  <section id="aba3" class="aba-conteudo">
    <!-- Conteúdo da aba 3 -->
<!-- ABA 03 - Estat├¡sticas -->
<div class="aba" id="aba3">
  <h2>­ƒôè Estat├¡sticas</h2>

  <ul>
    <li>Total de compromissos: <strong><?= $total_compromissos ?></strong></li>
    <li>Compromissos por dia da semana:</li>
    <ul>
      <?php foreach ($compromissos_por_dia as $num => $qtd): ?>
        <li><?= $dias[$num] ?? "Desconhecido" ?>: <?= $qtd ?></li>
      <?php endforeach; ?>
    </ul>
    <li>├Ültimo compromisso cadastrado: <strong><?= $ultimo_evento ?></strong></li>
  </ul>
</div>
  </section>
</div>

</body>
</html>


