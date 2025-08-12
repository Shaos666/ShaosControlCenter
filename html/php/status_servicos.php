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

// ✅ Função agora fora de "testar"
function verificar_cron($script) {
    $cron = (string) shell_exec("crontab -l 2>/dev/null");
    return str_contains($cron, $script);
}

// Corrigido: cast explícito
$containers = (string) shell_exec("docker ps --format '{{.Names}}'");
$status_apache = str_contains($containers, "dashboard") || str_contains($containers, "apachephp");
$status_mariadb = str_contains($containers, "mariadb");

$git_path = trim((string) shell_exec("which git"));
$status_git = !empty($git_path);

$docker_info = (string) shell_exec("docker info 2>/dev/null");
$status_docker = str_contains($docker_info, "Server Version");

$zips = glob('/mnt/g/Deposito/Backup_Docker/*/*/sistema_' . date("Y-m-d") . '_*.zip');
$status_backup = !empty($zips);

$status_cron = verificar_cron('startdodia.sh');

// 🔍 Verifica se existe algum .sql de hoje no diretório de backup
$status = [
    testar("Apache", $status_apache, "Container 'dashboard' ou 'apachephp' ativo"),
    testar("MariaDB", $status_mariadb, "Container 'mariadb' ativo"),
    testar("Git", $status_git, $git_path ?: "Git não encontrado"),
    testar("Docker", $status_docker, "Docker respondendo"),
    testar("Backup", $status_backup, count($zips) . " arquivo(s) ZIP encontrados hoje"),  // ✅ <- aqui
    testar("Cron", $status_cron, $status_cron ? "Agendamento encontrado" : "Script ausente no cron")    
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
