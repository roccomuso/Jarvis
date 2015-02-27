<?php
// Questo proxy è necessario, poichè le richieste in ajax da un dominio (come localhost) ad un altro dominio, vengono bloccate per evitare attacchi di tipo XXS.
// Se però la richiesta al dominio remoto è uno script .php come questo a farla e poi passa le info allo script ajax sullo stesso dominio, non ci sono problemi.

if (!isset($_GET['url'])) die();
$url = urldecode($_GET['url']);
$url = 'http://' . str_replace('http://', '', $url); // Avoid accessing the file system
echo file_get_contents($url);

?>