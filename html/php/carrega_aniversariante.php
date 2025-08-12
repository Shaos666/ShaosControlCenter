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
            $nome  = htmlspecialchars($row['nome']);
            $grupo = htmlspecialchars($row['tipo']);

            echo "<div class='quadro-aniversariante'>";
            echo "  <div class='linha'>";
            echo "    <div class='emoji-aniversariante'>🎉</div>";
            echo "    <div class='nome-aniversariante'>$nome</div>";
            echo "  </div>";
            echo "  <div class='linha'>";
            echo "    <div class='vazio'></div>";
            echo "    <div class='referencia-aniversariante'>($grupo)</div>";
            echo "  </div>";
            echo "</div>";
        }
    } else {
        echo "<div class='quadro-aniversariante'>";
        echo "  <div class='linha'>";
        echo "    <div class='emoji-aniversariante'>🚫</div>";
        echo "    <div class='nome'>Nenhum aniversariante hoje</div>";
        echo "  </div>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "<div class='quadro-aniversariante'>";
    echo "  <div class='linha'>";
    echo "    <div class='emoji-aniversariante'>❌</div>";
    echo "    <div class='nome'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "  </div>";
    echo "</div>";
}
