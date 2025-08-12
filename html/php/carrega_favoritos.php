<?php
include_once __DIR__ . '/conexao.php';

try {
    $stmt = $conn->prepare("SELECT nome, url FROM favoritos WHERE visivel = 1 ORDER BY nome ASC");
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        foreach ($resultados as $row) {
            $url = $row["url"];
            if (!preg_match("/^https?:\/\//", $url)) {
                $url = "http://" . $url;
            }
            $nome = htmlspecialchars($row['nome']);
            echo "<li><a href='{$url}' target='_blank'>{$nome}</a></li>";
        }
    } else {
        echo "<li><em>Sem links visíveis.</em></li>";
    }
} catch (PDOException $e) {
    //    echo "<li><em>Erro ao carregar favoritos: {$e->getMessage()}</em></li>";
    //    echo "<div class='favorito-item'>&#10040; <a href='{$url}' target='_blank'>{$nome}</a></div>";
    //    echo "<div class='favorito-item'><a href='{$url}' target='_blank'>{$nome}</a></div>";
    echo "<div class='favorito-item'><span class='estrela'></span><a href='{$url}' target='_blank'>{$nome}</a></div>";
}
