<?php
$mesAtual = date('n');
$anoAtual = date('Y');
$diaAtual = date('j');

// Nome do mês manual (pt-BR)
$nomesMes = [
  1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
  'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'
];
$nomeMes = $nomesMes[$mesAtual];

// Total de dias no mês
$ultimoDia = (new DateTime("$anoAtual-$mesAtual-01"))->format('t');

// Dia da semana do primeiro dia do mês (0 = domingo)
$inicioSemana = date('w', strtotime("$anoAtual-$mesAtual-01"));

// Dias da semana
$diasSemana = ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'];

echo "<table class='calendario'>";
echo "<thead><tr><th colspan='7'>" . ucfirst($nomeMes) . " de $anoAtual</th></tr></thead>";
echo "<tr>";
foreach ($diasSemana as $dia) echo "<th>$dia</th>";
echo "</tr><tr>";

$coluna = 0;

// Espaços antes do primeiro dia
for ($i = 0; $i < $inicioSemana; $i++) {
    echo "<td></td>";
    $coluna++;
}

// Dias do mês
for ($dia = 1; $dia <= $ultimoDia; $dia++) {
    if ($coluna == 7) {
        echo "</tr><tr>";
        $coluna = 0;
    }

    $classe = ($dia == $diaAtual) ? "style='background-color:lime; color:black;'" : '';
    echo "<td $classe>$dia</td>";
    $coluna++;
}

// Espaços finais
while ($coluna < 7) {
    echo "<td></td>";
    $coluna++;
}
echo "</tr></table>";
?>
