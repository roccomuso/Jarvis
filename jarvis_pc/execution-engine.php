<?php
//riceve comandi vocali dall'interfaccia web
$comando_grezzo = $_GET['exp_final'];
$ip_provenienza = $_SERVER['REMOTE_ADDR'];

/*
A sua volta l'execution-engine può tener traccia dei comandi eseguiti e unitamente a ciò inoltrare la richiesta ad altri script in PYTHON
che la prenderanno in carico eseguendola. (gli script in python infatti interagiscono con la seriale ed altri dispositivi HARDWARE).
Prima di ciò però, il comando grezzo deve essere ricondotto ad un comando valido e riconosciuto.

Per inserire una nuova funzionalità abbinata ad un riconoscimento di una frase, è sufficiente definire la funzione in: moduli-funzione.php
e inserire eventuali frasi, con sinonimi che fan riferimento alla funzione definitiva, nel file: lista-comandi.xml
*/

if (file_exists('lista-comandi.xml')) {
    $comandi = simplexml_load_file('lista-comandi.xml'); // usiamo un file .xml e non una base di dati relazionale. NoSQL style ;)
	}else die("<h1>Il file xml dei comandi non esiste!</h1>");

// RICONDUCIAMO IL COMANDO GREZZO AD UN COMANDO RICONOSCIUTO.

include("functions.php"); //includiamo le funzioni per manipolare il comando grezzo.

$comando_grezzo = strtolower($comando_grezzo); // ogni lettera diventa minuscola.

$comando_grezzo = str_to_num($comando_grezzo); // trasformiamo i numeri letterali: zero, uno, due in caratteri arabi: 0,1,2 etc..

$comando_grezzo = str_replace("jarvis", "", $comando_grezzo); //cancelliamo dalla stringa il nome dell'assistente vocale

$words_arr = explode(" ", $comando_grezzo); // ogni singola parola viene inserita in una componente di un array.


/* RICONOSCIMENTO ED ESECUZIONE DEL COMANDO VOCALE */


$interact_words = ""; //conterrà l'eventuale valore interattivo espresso vocalmente, che andrà trattato e passato come argomento alle funzioni. Esempio cmd: riproduci eminem. $val = "eminem", valore che verrà trattato dalla funzione.
$z = 1;

//Diamo priorità ai comandi interattivi, cicliamo prima sulla lista comandi interattivi cmd_i (se è interattivo parte del comando vocale dovrà essere interpretato e quindi usato come parametro ad alcune funzioni.)

	for($i = 0; $i < count($comandi->cmd_i); $i++){ //cicliamo su ogni comando in lista-comandi.xml per verificare se $words_arr contiene parole riconosciute nella lista comandi interattivi.

		if ($interact_words = match_cmd_i($words_arr, $comandi->cmd_i[$i]->text)){  // La funzione match_cmd_i() e' definita in functions.php - Se entra in questo if statement vuol dire che almeno una parola in $comandi->cmd_i[$i]->text è presente in $words_arr, il comando interattivo può essere eseguito.
			$funz = $comandi->cmd_i[$i]->funzione;
			include("moduli-funzione.php");
			//esecuzione della funzione
			@call_user_func("$funz", $interact_words); //chiama la funzione passata come argomento, e da come argomento a tale funzione $interact_words. Con l'operatore @ nascondiamo eventuali warning dovuti alla mancanza della funzione che si vuol chiamare.
			//usciamo dal ciclo:
			$z = 0; //in questo modo non ciclerà sui comandi base, essendo che già il comando è stato riconosciuto ed eseguito come interattivo.
			break;
			}
		
	}

// Cicliamo sui comandi base per verificare adesso se piuttosto che interattivo è un comando base:

	for($i = 0; $i < count($comandi->cmd) && $z; $i++){ //cicliamo su ogni comando in lista-comandi.xml per verificare se $words_arr contiene parole riconosciute nella lista comandi base.

		if (match_cmd($words_arr, $comandi->cmd[$i]->text)){  // La funzione match_cmd() e' definita in functions.php - Se entra in questo if statement vuol dire che ogni parola in $comandi->cmd[$i]->text è presente in $words_arr, il comando può essere eseguito.
			$funz = $comandi->cmd[$i]->funzione;
			include("moduli-funzione.php");
			//esecuzione della funzione
			@call_user_func("$funz"); //chiama la funzione passata come argomento. Con l'operatore @ nascondiamo eventuali warning dovuti alla mancanza della funzione che si vuol chiamare.
			//usciamo dal ciclo:
			break;
			}
		
	}

	if ($i == count($comandi->cmd)) echo "<em>Comando non riconosciuto!</em>";


/*
eventualmente questo script motore di esecuzione, la conferma del comando la da in due possibili modi.
1. restituendone il messaggio che verrà stampato dall'interfaccia web (da cui il comando vocale era stato inviato).
2. conferma attraverso esecuzione vocale, usando lo script php-TTS text to speech, che si appoggia anch'esso al motore vocale di google translate.
*/



?>