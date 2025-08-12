# cotacoes_coletor.py
import requests
import json
import os

URL = "https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,BTC-BRL"
#ARQUIVO_SAIDA = "/home/leandro/docker/projetos/apachephp/html/dashboard/data/cotacoes.json"
PASTA_BASE = os.path.expanduser("~/docker/projetos/apachephp/html/dashboard")
ARQUIVO_SAIDA = os.path.join(PASTA_BASE, "data", "cotacoes.json")


try:
    resposta = requests.get(URL)
    dados = resposta.json()

    cotacoes = {
        "USD": dados["USDBRL"]["bid"],
        "EUR": dados["EURBRL"]["bid"],
        "BTC": dados["BTCBRL"]["bid"]        
    }    

    with open(ARQUIVO_SAIDA, "w") as f:
        json.dump(cotacoes, f)

    print("Cotações atualizadas com sucesso!")

except Exception as e:
    print("Erro ao coletar cotações:", str(e))

