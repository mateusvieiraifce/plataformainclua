import pandas as pd
import os

def juntar_arquivos_excel(pasta):
    # Lista para armazenar todos os DataFrames
    dataframes = []
    
    # Percorrer todos os arquivos na pasta
    for arquivo in os.listdir(pasta):
        if arquivo.endswith(('.xlsx', '.xls')):
            caminho_completo = os.path.join(pasta, arquivo)
            
            # Ler o arquivo Excel
            df = pd.read_excel(caminho_completo)
            dataframes.append(df)
    
    # Juntar todos os DataFrames
    df_final = pd.concat(dataframes, ignore_index=True)
    
    return df_final

# Exemplo de uso
df_completo = juntar_arquivos_excel('.')
df_completo.to_excel('consolidado.xlsx', index=False)