<?php
//file included from tts.php
/*
*	Store the information about mp3 files in XML log file.
*
* 	This script records and updates the log in the XML log file.
*/

//variabili ricevute da tts.php che include questo script.
//$testo_originale
//$path_dir;
//$file_name;

if (file_exists('mp3-files.xml')) {
    $mp3files = simplexml_load_file('mp3-files.xml');
	}else die("<h1>Il file xml di log non esiste!</h1>");

	
//echo $mp3files->mp3[0]->text; //esempio di stampa di un valore nel tag <text>.
//$mp3files->mp3[1]->addChild("TAG","valore tag"); //esempio di inserimento di un figlio ad un nodo.

$new_node = $mp3files->addChild("mp3");

$new_node->addChild("text","$testo_originale");
$new_node->addChild("path","$path_dir");
$new_node->addChild("file_name","$file_name.mp3");


$mp3files->asXML("mp3-files.xml"); //attualizza le modifiche sul file.

?>