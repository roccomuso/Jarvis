<?php
header("Access-Control-Allow-Methods: POST, GET");
ERROR_REPORTING(E_ALL);

if (isset($_GET['action'])) {

$comando = $_GET['action'];
//$comando = preg_replace('/[^a-zA-Z0-9]/', '', $comando); //vengono filtrati tutti i caratteri speciali, disponibili lettere minuscole, maiuscole e numeri.
$ip = $_SERVER['REMOTE_ADDR'];

//funzione per trasformare qualsiasi numero scritto letteralmente ex. due, tre in 2, 3  etc..
function str_to_num($stringa){
$arr_lett = array("zero","uno","due","tre","quattro","cinque","sei","sette","otto","nove","dieci","undici","dodici","tredici","quattordici","quindici"); //fino a quindici max.
$arr_num = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15); //fino a 15 max.
$str = str_replace($arr_lett, $arr_num, $stringa);
return $str;
}

$comando = str_to_num($comando); // trasformiamo i numeri in caratteri arabi.
$comando = strtolower($comando); // ogni lettera diventa minuscola.

//scriviamo il file di log.txt che ci indica il comando lanciato, a che ora, e da qualche indirizzo IP:

// . . .


//scriviamo il file di comando.txt
$random = (isset($_GET['code'])) ? $_GET['code'] : rand(1000,9999); //il codice univoco del comando puo' essere inviato tramite url, altrimenti viene generato in automatico.
$comando = $comando." ".$random;
echo $comando;

$filename= "comando.txt";
$file = fopen($filename, "w") or exit("errore apertura file");
$str = fwrite($file, "$comando");
fclose($file);

}

//se è presente il parametro "status", verrà restituito l'ultimo valore nel file di log. Questo parametro viene usato dalla richiesta in AJAX per ottenere il valore.

if (isset($_GET['luce'])){ // MOSTRA SOLO LO STATO DELLA LUCE
$filename = "luce.txt";

		if ($_GET['luce'] != ""){

			$comand = ($_GET['luce'] == "on") ? "on" : "off" ;
			$file=fopen($filename,"w") or exit("Impossibile aprire il file!");
			$str = fwrite($file, "$comand");
			fclose($file);

		}else{ //se viene richesto solo luce, senza passare valori, stampa semplicemente il valore attuale contenuto in luce.txt (è possibile richiamare direttamente luce.txt per far prima, questo pezzo di codice è DEPRECATO)
			
			$file=fopen($filename,"r") or exit("Impossibile aprire il file!");
			$str = fread($file, filesize($filename));
			echo $str;

			fclose($file);
		}
}

if (isset($_GET['status2'])){ // MOSTRA IL COMANDO + IL CODICE CHE IDENTIFICA IL COMANDO UNIVOCAMENTE (ex: off 8392)  (si può richiamare direttamente comando.txt, motivo per cui questo blocco di codice è DEPRECATO)
	$filename = "comando.txt";
	$file=fopen($filename,"r") or exit("Impossibile aprire il file!");
	$str = fread($file, filesize($filename));

	echo $str;

	fclose($file);
}

?>