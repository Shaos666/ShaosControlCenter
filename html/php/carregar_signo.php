<?php
function obterSigno($dia, $mes) {
  $signos = [
    ['nome' => 'Capricórnio', 'emoji' => '♑', 'inicio' => [12, 22], 'fim' => [1, 19]],
    ['nome' => 'Aquário',     'emoji' => '♒', 'inicio' => [1, 20],  'fim' => [2, 18]],
    ['nome' => 'Peixes',      'emoji' => '♓', 'inicio' => [2, 19],  'fim' => [3, 20]],
    ['nome' => 'Áries',       'emoji' => '♈', 'inicio' => [3, 21],  'fim' => [4, 19]],
    ['nome' => 'Touro',       'emoji' => '♉', 'inicio' => [4, 20],  'fim' => [5, 20]],
    ['nome' => 'Gêmeos',      'emoji' => '♊', 'inicio' => [5, 21],  'fim' => [6, 20]],
    ['nome' => 'Câncer',      'emoji' => '♋', 'inicio' => [6, 21],  'fim' => [7, 22]],
    ['nome' => 'Leão',        'emoji' => '♌', 'inicio' => [7, 23],  'fim' => [8, 22]],
    ['nome' => 'Virgem',      'emoji' => '♍', 'inicio' => [8, 23],  'fim' => [9, 22]],
    ['nome' => 'Libra',       'emoji' => '♎', 'inicio' => [9, 23],  'fim' => [10, 22]],
    ['nome' => 'Escorpião',   'emoji' => '♏', 'inicio' => [10, 23], 'fim' => [11, 21]],
    ['nome' => 'Sagitário',   'emoji' => '♐', 'inicio' => [11, 22], 'fim' => [12, 21]],
  ];

  foreach ($signos as $s) {
    $inicio = $s['inicio'];
    $fim = $s['fim'];

    if (
      ($mes == $inicio[0] && $dia >= $inicio[1]) ||
      ($mes == $fim[0] && $dia <= $fim[1])
    ) {
      return $s['emoji'] . " Signo: " . $s['nome'];
    }
  }
  return "Signo desconhecido";
}

// Data atual
$dia = date("d");
$mes = date("m");

echo obterSigno((int)$dia, (int)$mes);
?>
