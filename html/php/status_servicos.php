<?php
date_default_timezone_set('America/Sao_Paulo');

function testar($nome, $resultado, $tooltip = '') {
    $icone = match ($resultado) {
        true  => '✅',
        false => '❌',
        null  => '⚠️',
    };
    $title = htmlspecialchars($tooltip ?: ($resultado ? "OK" : "Falha ou Inativo"));
    return "<span class='status-item' title='{$title}'>{$nome}: {$icone}</span>";
}

// Corrigido: cast explícito
$containers = (string) shell_exec("docker ps --format '{{.Names}}'");
$status_apache = str_contains($containers, "dashboard") || str_contains($containers, "apachephp");
$status_mariadb = str_contains($containers, "mariadb_foxtrot");

$git_path = trim((string) shell_exec("which git"));
$status_git = !empty($git_path);

$docker_info = (string) shell_exec("docker info 2>/dev/null");
$status_docker = str_contains($docker_info, "Server Version");

// 🔍 Verifica se existe algum .sql de hoje no diretório de backup
$arquivos = glob('/mnt/g/Deposito/Backup_Docker/*' . date("Y-m-d") . '*.sql');
$status_backup = !empty($arquivos);

$status = [
    testar("Apache", $status_apache, "Container 'dashboard' ou 'apachephp' ativo"),
    testar("MariaDB", $status_mariadb, "Container 'mariadb_foxtrot' ativo"),
    testar("Git", $status_git, $git_path ?: "Git não encontrado"),
    testar("Docker", $status_docker, "Docker respondendo"),
    testar("Backup", $status_backup, count($arquivos) . " arquivo(s) .SQL encontrado(s) com data de hoje"),
];

$html = '<div class="status-bar">' . implode('&nbsp;&nbsp;', $status) . '</div>';

// Garante que o diretório existe
$saida = __DIR__ . '/../status_dashboard.html';
$dir = dirname($saida);

if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Verificação ao salvar o arquivo
if (!file_put_contents($saida, $html)) {
    echo "❌ Falha ao salvar em: $saida\n";
} else {
    echo "✅ Arquivo salvo com sucesso: $saida\n";
}
