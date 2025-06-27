// FoxTrot Refresh: Recarregar a página 1 minuto após a meia-noite
function agendarRefreshMeiaNoite() {
  const agora = new Date();
  const meiaNoite = new Date();

  meiaNoite.setHours(24, 1, 0, 0); // 00:01 do próximo dia

  const tempoAteMeiaNoite = meiaNoite.getTime() - agora.getTime();

  setTimeout(() => {
    location.reload();
  }, tempoAteMeiaNoite);
}

agendarRefreshMeiaNoite();

