<?php
ERROR_REPORTING(E_ALL);
/* MODULI ESECUTIVI
Sezione per l'integrazione di moduli, per implementare facilmente nuove funzioni aggiuntive è sufficiente aggiungerne una qui in lista, e scriverne il nome abbinato
nel file lista-comandi.xml assieme alle frasi che verranno associate all'esecuzione di quella funzione. In questo modo il sistema è facilmente scalabile.

Ogni funzione qui definita può includere script php, o eseguire comandi attraverso script python (per funzioni legate maggiormente all'hardware e alla macchina locale).
*/

################## MODULI FUNZIONI INTERATTIVE (cioè accettano catture vocali come parametri) #########################

function play($titolo){
//in caso di debug degli errori aggiungere un ulteriore parametro nel comando: 2>&1  (esempio: system("dir 2>&1");  )
system(".\machine-functions\play.py $titolo"); // riproduce l'mp3 che ha per titolo: $titolo.
//echo "entrato in play...";

}

function play_movie($titolo){

system(".\machine-functions\play.py film $titolo"); // riproduce il film che ha per titolo: $titolo.
//echo "entrato in play_movie...";

}

function dici($txt){ //pronuncia vocalmente $txt
$txt = $txt;
require "./php-TTS/tts.php";

$tts = new TextToSpeech(); //creiamo un oggetto, istanziando la classe inclusa da tts.php
$file_name = time();

$tts->setText($txt,$file_name,"./php-TTS/files/"); //richiamiamo il metodo definito nella classe TextToSpeech.

$file_mp3 = "./php-TTS/files/$file_name.mp3";

echo "
<audio controls='controls' autoplay='autoplay' id='audio-mp3'>
  <source src='$file_mp3' type='audio/mp3' />
  Your browser does not support the audio tag.
</audio> 
";

}

################### MODULI FUNZIONI CLASSICHE #################################

function luceON(){
echo "<iframe src='http://www.roccomusolino.com/jarvis_server/switch.php?luce=on' height='1' width='1'></iframe>"; //per far aggiornare anche l'interfaccia grafica luce.html di jarvis_server
echo "FUNZIONE CHIAMATA, accendo la luce, esito: ";
//inviamo comando allo script in python che lo invia tramite seriale al micro-controllore:
system(".\machine-functions\serial-communication.py m"); // il micro-controllore è programmato per attivare il rele' quando riceve il carattere "m"
}

function luceOFF(){
echo "<iframe src='http://www.roccomusolino.com/jarvis_server/switch.php?luce=off' height='1' width='1'></iframe>"; //per far aggiornare anche l'interfaccia grafica luce.html di jarvis_server
echo "FUNZIONE chiamata, spengo la luce, esito: ";
//inviamo comando allo script in python che lo invia tramite seriale al micro-controllore:
system(".\machine-functions\serial-communication.py n"); // il micro-controllore è programmato per disattivare il rele' quando riceve il carattere "n" 
}

function orario(){
$data_ora = "Oggi abbiamo ".date("d-m-Y")." e sono le ore ".date("H:i");
echo $data_ora;
dici($data_ora);

}

function time_ora(){
$ora = "Sono le ".date("H:i");
echo $ora;
dici($ora);
}

function time_data(){
$data = "Oggi abbiamo ".date("d-m-Y");
echo $data;
dici($data);
}

function identificazione_nome(){
dici("Sono Zooe, assistente vocale di questo sistema di controllo.");
}

function identificazione_who(){
dici("Il mio creatore è Rocco.");
}

// AMBIENTAZIONE

function atmosfera_default(){

system(".\machine-functions\serial-communication.py g"); //inviamo in seriale il carattere "g" interpretato dal micro-controllore come "invia un segnale IR per attivare striscia di led passiva"
system(".\machine-functions\play.py dancing"); //fa partire una canzone di default "Dancing - Elisa"
}

function stop_atmosfera(){
// . . . <in costruzione> . . invia tramite telnet a VLC il comando per stoppare la musica.
system(".\machine-functions\serial-communication.py s"); //stoppiamo la striscia led passiva, inviando il carattere "s" in seriale
}

// SVAGO
function bomba_mano(){
dici("tutti atterra!"); //scritto così viene pronunciato meglio <.<
}

function f_rocco(){
dici("Rocco? merita 110 ellode");
}

function f_velociraptor(){
dici("grandi, grossi e veloci");
}


//tempo atmosferico

//browser (ex. cercami iron mon ... si apre google con iron man)



?>