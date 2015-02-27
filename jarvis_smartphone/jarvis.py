#
# Questo file in pyhon viene eseguito dallo smartphone attraverso sl4a
# La versione di python utilizzata sullo smartphone e' la 2.7 e quindi la sintassi differisce dalla 3.1
#

import android
import urllib2
import android
import re

class recognize(object):
  done=0
  errors=0


  def run(self):
     while self.done==0:
        print '\n\n'
        self.droid = android.Android()

        # loop until "done"
        if self.done==0:
          # recognize speech
          results=self.droid.recognizeSpeech()
          # check for errors, we'll give user 2 chances
          # then we exit
          if (results.error != None):
            self.errors=self.errors+1
            # 1st error
            if self.errors==1:
              self.droid.ttsSpeak('Come hai detto? ripeti')
            # 2nd error
            else:
              print 'debug: exit due to error'
              self.done=1
              self.droid.ttsSpeak('Non riesco a sentirti bene. Addio.')
          else:
            # got something, set error=0, done=1
            self.errors=0
            self.done=1
            # convert recognition to string
            text = str (results.result)
            # display toast message of recognized text
            self.droid.makeToast(text)

            # cerchiamo eventuali parole chiave che presuppongono l'interpretazione su smartphone e non l'invio al server remoto
            # infatti il controllo dei comandi vocali ricevuti avviene preventivamente dallo smartphone, se non riconosciuti come comandi destinati allo smartphone vengono inoltrati al server
            if re.search('vibra',text):
              self.droid.vibrate(1000)
              self.done = 0 #continuiamo a stare dentro al ciclo

            if re.search('attiva wireless',text):
              self.droid.toggleWifiState()
              self.done = 0 #continuiamo a stare dentro al ciclo
              
            elif text: #inviamo il testo riconosciuto al server remoto [I COMANDI SOPRA VENGONO INTERPRETATI DA SMARTPHONE]
              try:
                text = text.replace(" ","+")
                u = urllib2.urlopen('http://www.roccomusolino.com/jarvis_server/switch.php?action='+text)
                #self.droid.ttsSpeak('comando inviato!')
                print "Comando inviato!"
              except:
                print "Eccezione, controllare la connessione..."
              self.done=0 #continuiamo a stare dentro al ciclo
            
r=recognize()
r.run()
