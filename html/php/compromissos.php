<?php
// compromissos.php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Compromissos</title>
    <link rel="stylesheet" href="../css/matrix-theme.css">
    <script src="../js/morpheus.js" defer></script>
</head>

<body class="mod-auxiliar-body">
    <div class="mod-auxiliar-container">
        <div class="mod-auxiliar-header">
            <h2>Gerenciamento dos Compromissos</h2>
            <div class="centralizar">
                <div class="mod-voltar-container">
                    <a href="#" onclick="window.close();" class="mod-botao-voltar">⮐ Voltar</a>
                </div>
            </div>
        </div>

        <div class="mod-auxiliar-tabs">
            <div class="mod-tablink active" onclick="modOpenTab(event, 'mod-tab1')">
                <img src="../img/alvo.png" alt=""> Lista de Compromissos
            </div>
            <div class="mod-tablink" onclick="modOpenTab(event, 'mod-tab2')">
                <img src="../img/caneta.png" alt=""> Inclusão de Compromissos
            </div>
            <div class="mod-tablink" onclick="modOpenTab(event, 'mod-tab3')">
                <img src="../img/disquete.png" alt=""> Histórico e Estatísticas
            </div>
        </div>

        <div id="mod-tab1" class="mod-tabcontent" style="display:block;">
            <h3>Lista de Compromissos</h3>
            <p>Conteúdo da aba Compromissos...</p>
        </div>

        <div id="mod-tab2" class="mod-tabcontent">
            <h3>Inclusão de Compromissos</h3>
            <p>Conteúdo da aba Compromissos...</p>
        </div>

        <div id="mod-tab3" class="mod-tabcontent">
            <h3>Histórico e Estatísticas</h3>
            <p>Conteúdo da aba Estatísticas...</p>
        </div>
    </div>
</body>

</html>