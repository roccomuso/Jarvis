import serial
import sys
import time

'''
Questo script viene richiamato da linea di comando passandogli argomenti in linea: argv[1] etc.
L'argomento che gli si passa e' un comando, interpretato e inviato in seriale.
'''

def scan():
    """scan for available ports. return a list of tuples (num, name)"""
    available = []
    for i in range(256):
        try:
            s = serial.Serial(i)
            available.append( (i, s.portstr))
            s.close()   # explicit close 'cause of delayed GC in java
        except serial.SerialException:
            pass
    return available

def connessione_seriale(port):
    """ funzione per connessione alla porta seriale """
    try:
        return serial.Serial(port, 9600)
    except serial.SerialException:
        print("verificatosi ERRORE...")


porte = scan()
if len(porte): # porte seriali libere
   porta = porte[0][1] # ci connettiamo alla prima porta disponibile

   ser = connessione_seriale(porta)
   # gli sleep qua sotto sono necessari per evitare che arduino vada in reset, passa troppo poco tempo fra la connessione e l'invio del comando in seriale altrimenti
   time.sleep(1) #  attesa
   ser.setDTR(level=0)
   time.sleep(1) #tempo di attesa di un secondo dovrebbe essere sufficiente

   cmd = sys.argv[1] # cmd ricevuto da linea di comando

   ser.write(cmd.encode("latin1")) #inviamo il comando in seriale (sara' il micro-controllore a interpretare il cmd inviato. [ex. se "m" attiva rele', se "n" disattiva rele])
   print("Fatto!")
   
   time.sleep(0.5)
   ser.close()
       
else:
   print("Nessun dispositivo seriale connesso oppure porta seriale occupata!")

'''
print("Found ports:")
for n,s in scan():
   print("(%d) %s" % (n,s))
'''

  
