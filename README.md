# Jarvis
Distributed Domotic System


Il progetto consta di 3 cartelle, che formano assieme il sistema completo jarvis.
jarvis_pc (jarvis pc necessita di essere eseguito su un singolo pc all'interno dell'abitazione, preleva i comandi dal jarvis server e li esegue localmente nell'abitazione, attualmente il riconoscimento vocale di cui dispone l'interfaccia funziona su Chrome versione 25 o superiori)
jarvis_server (è un server attivo 24h/24h che si occupa principalmente di ricevere i comandi dall'intefaccia smartphone o interfaccia server grafica)
jarvis_smartphone (può girare anche su più terminali che invieranno sempre e comunque i comandi remoti al jarvis_server)
jarvis_microcontroller ( ... )

jarvis_pc con un sistema di formattazione xml, associa ad un comando vocale una semplice funzione (lista-comandi.xml [vedi comandi interattivi e comandi classici]). Questo gli fornisce grande flessibilità e scalabilità (propensione alla crescita).
In jarvis_pc troviamo diversi file e cartelle:
Il file index.html è il cuore dell'interfaccia vocale e grafica su pc, nonchè il file che si occupa di lanciare richieste asincrone agli script in php, che interpretano e processano i comandi ricevuti. Le richieste asincrone per semplici pagine da parsare vengono fatte con l'ausilio di un proxy, poichè in condizioni normali (across domain, da un dominio a un altro) le richieste ajax verso l'esterno vengono bloccate. Se a questa richiesta aggiungiamo l'invio di dati in GET o POST, il proxy locale non funziona più, ma bisogna settare nella pagina remota la "propensione" ad accettare richieste di questo tipo, aggiungendo negli header questa intestazione: header("Access-Control-Allow-Methods: POST, GET");  [come fatto appunto in jarvis_server/switch.php]
Il sistema index.html recupera i comandi che verranno interpretati localmente sul pc su cui è stato lanciato. Però a sua volta è capace anche di lanciare comandi attraverso il riconoscimento vocale. Per questo motivo è stato implementato un sistema a semafori, che garantisce la priorità dei comandi che partono da jarvis_pc (NB. i comandi lanciati e interpretati da jarvis_pc vengono sincronizzati anche sul jarvis_server).
Il file lista-comandi.xml contiene i comandi vocali riconosciuti e la rispettiva funzione associata. (definita in moduli-funzione.php)
Il file execution-engine.php ...
Nella directory machine-functions son presenti i moduli in python per effettuare operazioni strettamente legate alla macchina su cui gira il web server con l'index di jarvis_pc.
In machine-functions troviamo infatti:
play.py : ...
serial-communication.py : La comunicazione da pc verso dispositivi seriali connessi. I dispositivi disponibili vengono automaticamente ricercati dallo script ...
Il file machine-functions\config.py contiene il percorso assoluto al file di configurazione.xml (presente in jarvis_pc) necessario per individuare a sua volta, ulteriori directory usate da funzioni generiche.

proxy.php è uno script di proxy usato da webspeechdemo.html per l'utilizzo della funzione in ajax per richiamare in remoto il file comando.txt, (presente sul server remoto e generato da switch.php che si occupa di ricevere i comandi dall'interfaccia smartphone).
non è possibile infatti richiamare direttamente da webspeechdemo.html che è in localhost, tramite ajax, altri file che sono su domini diversi (questo per evitare xss).



In jarvis_smartphone si compone del jarvis.py che è l'app che gira sullo smartphone (tramite sl4a) per il riconsocimento vocale, che interpreta localmente i comandi che sono destinati allo smartphone (come ad esempio, vibra) e quelli non interpretabili localmente vengono inviati in remoto.
Vengono inviati in remoto e salvati in un file comando.txt scritto da switch.php che si occupa di ricevere i comandi da varie interfacce (quella smartphone e quella grafica, ad esempio luce.html).
Il comando scritto su comando.txt viene letto sia da webspeechdemo.html che gira in localhost sia dal Jarvis-serial-server-pc.py anch'egli in localhost e che ha il compito di interagire direttamente con la seriale.

Sia jarvis_pc che jarvis_smartphone contengono l'indirizzo del server, se quest'ultimo viene modificato, è necessario aggiornare jarvis_pc e jarvis_smartphone con il nuovo dominio/indirizzo del jarvis_server.
jarvis_pc prima di poter funzionare necessita che venga indicato lui, il percorso assoluto al file di configurazione (configurazione.xml), e questo percorso va modificato nel file: jarvis_pc\machine-functions\config.py
jarvis_server rimane in ascolto passivo, è un'interfaccia verso il mondo esterno, facilmente un dispositivo si può interfacciare inviando una richiesta GET con un comando che verrà poi preso in carico dal jarvis_pc per l'esecuzione.
jarvis_sartphone [attualmente per chi può installare sl4a] possiede un livello locale per l'interpretazione di comandi indirizzati allo smartphone (quali ad esempio, "vibra" o "chiama 3270703.."), i comandi non riconosciuti localmente vengono inviati al jarvis_server, e rimarranno la, in attesa che jarvis_pc li prenda ed esegui.
jarvis_pc possiede l'interfaccia vocale locale per l'interpretazione ed esecuzione dei comandi, e si occupa del fetching remoto dei comandi presenti sul jarvis_server. Per poter eseguire jarvis_pc bisogna aprire l'index.html dopo aver attivato in locale un web server con interprete php (vedi apache). NB. si richiama da localhost, non con percorso assoluto.

E' possibile sopprimere eventuali tempi di latenza, diminuendo i millisecondi per il refresh asincrono utilizzato per il retrieving dei dati (a discapito del consumo di banda), vedi ad esempio in jarvis_pc/index.html il pezzo di codice: setInterval("check_status()", 1500);  diminuendo ulteriormente i millisecondi, la funzione check_status() verrà richiamata più frequentemente, prelevando più velocemente i comandi dal jarvis_server (comando.txt), a discapito del consumo di banda.
Stesso discorso vale ovunque si effettui il refresh asincrono per il fetching di dati, vedi ad esempio in jarvis_server/luce.html l'istruzione analoga: setInterval("check_status()", 1300);  diminuendo il numero di millisecondi, l'interfaccia grafica luce.html sarà aggiornata con una frequenza maggiore (sempre a discapito della banda di connessione).
