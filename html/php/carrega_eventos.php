<?php
// carrega_eventos.php

include_once __DIR__ . '/conexao.php';
date_default_timezone_set('America/Sao_Paulo');

$diaAtual = date('j'); // dia do mês (1-31)
$mesAtual = date('n'); // mês (1-12)

$sql = "SELECT nome, id_tipo FROM eventos_calendario WHERE dia = ? AND mes = ? ORDER BY id_tipo, nome";
$stmt = $conn->prepare($sql);
$stmt->execute([$diaAtual, $mesAtual]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tipos = [
    1 => "🇧🇷 Feriado Nacional",
    2 => "🏞️ Feriado Estadual",
    3 => "🏙️ Feriado Municipal",
    4 => "🎗️ Comemorativo",
    5 => "🙏 Religioso",
    6 => "👤 Pessoal"
];

if (empty($result)) {
    echo "<p>Nenhum evento comemorativo hoje.</p>";
    exit;
}

echo "<ul class='eventos-lista'>";
foreach ($result as $row) {
    $nome = htmlspecialchars($row['nome']);
    $tipo = $tipos[$row['id_tipo']] ?? "❔ Outro";
    echo "<li title=\"{$tipo}\">{$nome}</li>";
}
echo "</ul>";
