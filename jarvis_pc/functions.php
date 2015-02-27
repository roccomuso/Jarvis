<?php //FUNZIONI PER MANIPOLARE IL COMANDO GREZZO RICEVUTO VOCALMENTE.

//funzione per trasformare qualsiasi numero scritto letteralmente ex. due, tre in 2, 3  etc..
function str_to_num($stringa){
$arr_lett = array("zero","uno","due","tre","quattro","cinque","sei","sette","otto","nove","dieci","undici","dodici","tredici","quattordici","quindici"); //fino a quindici max.
$arr_num = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15); //fino a 15 max.
$str = str_replace($arr_lett, $arr_num, $stringa);
return $str;
}


//ricerca di uno dei valori in un primo array in quello del secondo.
function match_arr($arr1, $arr2){
for($i = 0; $i < count($arr1); $i++)
if (in_array($arr[$i], $arr2)) return 1; //trovato

return 0; //nessun risultato trovato
}


//ricerca delle componenti dell'array nella stringa, restituisce true se tutte le componenti compaiono in una stringa
function match_cmd($arr, $str){
//complessità computazionale: count($arr) x count($str). 

$k=0;

$str = explode(" ", $str); //trasformiamo la stringa in componenti di array.

for($i = 0; $i < count($str); $i++){
	if (in_array($str[$i], $arr)) $k++; //parola trovata.

}

return ($k == count($str)) ? true : false; //se k è uguale alla lunghezza di $str allora il comando è riconosciuto. (vuol dire che nella stringa c'erano tutte le parole, anche se in ordine sparso).

}


//ricerca delle componenti del comando vocale in $comandi->cmd_i l'array di comandi interattivi.
function match_cmd_i($arr, $str){ //NB. $arr è l'array formato a partire dal COMANDO VOCALE. $str è una stringa che viene passata da altre parti del programma che ciclano sui COMANDI DISPONIBILI RICONOSCIUTI

$k=0;

$str = explode(" ", $str); //trasformiamo la stringa in componenti di array.

for($i = 0; $i < count($str); $i++){
	if (in_array($str[$i], $arr)) { //parola trovata.
		$arr = array_diff($arr, array($str[$i])); // in $arr avremo via via le parole non riconosciute nella lista comandi, necessarie come valore al nostro comando interattivo.
		$k++;
	}
}

//casting da array a stringa:
$arr = implode(" ", $arr);

return ($k == count($str)) ? $arr : 0; // Se $k è uguale alla lunghezza del comando riconosciuto, restituiamo $arr cioè le restanti parole non riconosciute, che rappresentano il valore aggiunto interattivo per il comando vocale interattivo (assolutamente necessaria la restituzione).
// Nel caso di nessun match invece che restituire il valore aggiunto si restituirà 0.

}


?>