<?php
// dashboard/php/rodar_coletor.php
$output = shell_exec("python3 ../scripts/cotacoes_coletor.py 2>&1");
echo $output;
?>
