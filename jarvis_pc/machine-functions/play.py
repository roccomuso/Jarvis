import os
import sys
import config #importiamo il file config.py


# riceve argomenti passati in linea di comando..
titolo_parziale = ""
i = 1
nome_tag = "dir_musica" 
try:
    if sys.argv[1] == "film":
        i = 2 #indica di prendere il titolo parziale partendo dall'indice 2 quindi evitando la keyword "film" passata come argomento
        nome_tag = "dir_film" #usato per il percorso della directory in cui ricercare prelevato dal file di configurazione
except:
    pass

xmlData = config.dom.getElementsByTagName(nome_tag)[0].toxml()
#il retrieve conterra' una stringa, tag compresi.
#prendiamo con lo slice solo il valore che ci interessa tra i tag <val></val>
cartella_file = xmlData[xmlData.index("<val>")+5:xmlData.index("</val>")]

while i < len(sys.argv):
    titolo_parziale = titolo_parziale + " " + sys.argv[i]
    i = i + 1

def find(name, path): # funzione di ricerca (non ricerca in sub-directory ma solo nel path indicato)
    i = 0
    name = name.lower() # tutti i caratteri minuscoli
    name = name.strip() # via gli spazi a inizio o fine stringa
    for root, dirs, files in os.walk(path):
        while i < len(files):
            if name in files[i].lower():
                return path+"\\"+files[i] #os.path.join(root, name)
            i = i + 1


percorso_file = find(titolo_parziale, cartella_file ) # NOME FILE (o parte del nome), PERCORSO DOVE CERCARLA ex. D:\Musica

if percorso_file:
    os.startfile(percorso_file) # eseguiamo il file
    print(titolo_parziale)
else:
    print("File non trovato!")
