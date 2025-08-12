<?php
date_default_timezone_set('America/Sao_Paulo');

// Algoritmo simples baseado no número do dia lunar (~29.53 dias)
function getFaseLua($timestamp = null)
{
    if ($timestamp === null) $timestamp = time();

    $anoBase = 2001;
    $lunaBase = strtotime("2001-01-24"); // Lua Nova em 24/01/2001
    $diasLunares = 29.53058867;

    $diasPassados = ($timestamp - $lunaBase) / 86400;
    $idadeDaLua = fmod($diasPassados, $diasLunares);

    $fases = [
        ["nome" => "Lua Nova",         "emoji" => "🌑", "inicio" => 0],
        ["nome" => "Crescente",        "emoji" => "🌒", "inicio" => 1.84566],
        ["nome" => "Quarto Crescente", "emoji" => "🌓", "inicio" => 5.53699],
        ["nome" => "Gibosa Crescente", "emoji" => "🌔", "inicio" => 9.22831],
        ["nome" => "Lua Cheia",        "emoji" => "🌕", "inicio" => 12.91963],
        ["nome" => "Gibosa Minguante", "emoji" => "🌖", "inicio" => 16.61096],
        ["nome" => "Quarto Minguante", "emoji" => "🌗", "inicio" => 20.30228],
        ["nome" => "Minguante",        "emoji" => "🌘", "inicio" => 23.99361],
        ["nome" => "Lua Nova",         "emoji" => "🌑", "inicio" => 27.68493],
    ];

    $faseAtual = end($fases);
    foreach ($fases as $fase) {
        if ($idadeDaLua < $fase["inicio"]) break;
        $faseAtual = $fase;
    }

    return "Fase da Lua: " . $faseAtual["nome"] . " " . $faseAtual["emoji"];
}

echo getFaseLua();
