<?php
date_default_timezone_set('America/Sao_Paulo');

$hoje = date("m-d");

require_once __DIR__ . "/conexao.php";

try {
    $sql = "SELECT nome, tipo FROM aniversariantes WHERE DATE_FORMAT(dn, '%m-%d') = :hoje";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hoje', $hoje);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            echo "<div class='aniversariante-bloco'>";
            echo "<span class='aniversariante-nome'>🎉 " . htmlspecialchars($row['nome']) . "</span>";
            echo "<span class='aniversariante-tipo'>(" . htmlspecialchars($row['tipo']) . ")</span>";
            echo "</div>";
        }
    } else {
        echo "<p style='text-align:center;font-size: 1.3em; font-weight: bold;'>&quot;Nenhum aniversariante hoje&quot;</p>";
    }
} catch (PDOException $e) {
    echo "<div class='aniversariante-nome'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
