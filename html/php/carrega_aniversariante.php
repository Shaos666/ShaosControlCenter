<?php
date_default_timezone_set('America/Sao_Paulo'); // muito importante!

$hoje = date("m-d");

require_once __DIR__ . "/conexao.php";

try {
    $sql = "SELECT nome FROM aniversariantes WHERE DATE_FORMAT(dn, '%m-%d') = :hoje";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hoje', $hoje);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            echo "<li>🎉 " . htmlspecialchars($row['nome']) . "</li>";
        }
    } else {
        echo "<li>🎂 Nenhum aniversariante hoje</li>";
    }
} catch (PDOException $e) {
    echo "<li>Erro ao buscar aniversariantes: " . htmlspecialchars($e->getMessage()) . "</li>";
}
?>
