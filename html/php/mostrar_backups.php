<?php
$relatorio = __DIR__ . '/relatorio_bkp.html';

if (file_exists($relatorio)) {
    include $relatorio;
} else {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Relatório de Backups</title>
    <style>
    body { background-color: black; color: #00ff00; font-family: monospace; padding: 20px; }
    h2 { color: #00ff00; }
    .botao-voltar {
      display: inline-block;
      margin-top: 30px;
      padding: 8px 14px;
      border: 1px dotted #0f0;
      border-radius: 8px;
      background-color: #111;
      color: #00ff00;
      text-decoration: none;
      font-size: 1.3em;
      margin-left: 30px;
    }
    .botao-voltar:hover {
      background-color: #0f0;
      color: black;
      font-weight: bold;
      box-shadow: 0 0 8px #0f0;
    }
    </style></head><body>";
    echo "<h2>⚠️ Relatório não encontrado</h2>";
    echo "<p>O arquivo <code>relatorio_bkp.html</code> ainda não foi gerado.</p>";
    echo "<a class='botao-voltar' href='javascript:window.close()'>Fechar</a>";
    echo "</body></html>";
}
?>

