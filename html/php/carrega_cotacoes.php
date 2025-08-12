<?php
// carrega_cotacoes.php

header('Content-Type: application/json');

$arquivo = __DIR__ . '/../data/cotacoes.json';

if (file_exists($arquivo)) {
    echo file_get_contents($arquivo);
} else {
    echo json_encode(["erro" => "Arquivo NÃO encontrado em $arquivo"]);
}
