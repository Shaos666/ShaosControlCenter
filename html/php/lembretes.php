<?php
// lembretes.php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lembretes</title>
    <link rel="stylesheet" href="../css/matrix-module.css">
    <script src="../js/morpheus.js" defer></script>
</head>

<body class="mod-auxiliar-body">
    <div class="mod-auxiliar-container">
        <div class="mod-auxiliar-header">
            <h2>Gerenciamento dos Lembretes</h2>
            <div class="centralizar">
                <div class="mod-voltar-container">
                    <a href="#" onclick="window.close();" class="mod-botao-voltar">⮐ Voltar</a>
                </div>
            </div>
        </div>

        <div class="mod-tabs">
            <button class="mod-tablink" onclick="modOpenTab(event, 'tab-edicao')">✏️ Edição</button>
            <button class="mod-tablink" onclick="modOpenTab(event, 'tab-inclusao')">➕ Inclusão</button>
            <button class="mod-tablink" onclick="modOpenTab(event, 'tab-historico')">📜 Histórico</button>
        </div>

        <div id="tab-edicao" class="mod-tabcontent">
            <h3>Lista de Lembretes</h3>
            <div class="mod-lista">Conteúdo da aba Lembretes...</div>
        </div>

        <div id="tab-inclusao" class="mod-tabcontent">
            <h3>Inclusão de Lembrete</h3>
            <form class="mod-formulario">
                <label for="lembrete">Lembrete:</label>
                <input type="text" id="lembrete" maxlength="100" />
                <span class="mod-caracteres">000</span>
                <br>
                <button class="mod-btn-salvar" type="submit">Salvar</button>
                <button class="mod-btn-cancelar" type="button">Cancelar</button>
            </form>
        </div>

        <div id="tab-historico" class="mod-tabcontent">
            <h3>Histórico</h3>
            <div class="mod-historico">Conteúdo da aba histórico...</div>
        </div>


    </div>
</body>

</html>