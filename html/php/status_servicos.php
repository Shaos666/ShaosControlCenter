<?php
function verifica_porta($host, $porta, $timeout = 1) {
  $conexao = @fsockopen($host, $porta, $errno, $errstr, $timeout);
  if ($conexao) {
    fclose($conexao);
    return true;
  } else {
    return false;
  }
}

$servicos = [
  "Apache"   => verifica_porta("localhost", 80),
  "MariaDB"  => verifica_porta("localhost", 3306),
  "Git"      => shell_exec("which git") ? true : false,
  "Docker"   => shell_exec("docker info > /dev/null 2>&1 && echo OK") ? true : false,
  "Backup"   => file_exists("/mnt/g/Deposito/Backup_Docker/ultimo_backup.log") // ajuste conforme sua lógica
];

echo "<p>";
foreach ($servicos as $nome => $status) {
  $cor = $status ? "✅" : "❌";
  echo "$nome: $cor &nbsp;&nbsp;";
}
echo "</p>";
?>
