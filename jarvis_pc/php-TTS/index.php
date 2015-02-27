<!DOCTYPE html>
<html>
<head>
<title>TTS - Google Text To Speech and PHP solution</title>


<script>

function prova(){
document.getElementById("audio-mp3").play();
}

</script>

</head>


<body>

<p>
Uses <a href="http://translate.google.com/support/">Google Translator</a> to convert text to speech (TTS) with PHP.
<br/>
Saves file as MP3 (converts to OGG using mp32ogg) and plays back with browsers built in HTML5 audio player.
<br/>
creating this for <a href="HeckleOnline.com">HeckleOnline.com</a>
<br/>
online convertor: http://translate.google.com/translate_tts?tl=en&q=Your Text Here
<br/>
Still having some issues with Firefox... Works with WebKit browsers; Safari and Chrome.
</p>

<?php
require "tts.php";

$tts = new TextToSpeech(); //creiamo un oggetto, istanziando la classe inclusa da tts.php
$file_name = time();

$heckle = "Comando non riconosciuto";
if ( isset($_GET['heckle']) ) $heckle = $_GET['heckle'];
$tts->setText($heckle,$file_name,"./files/"); //richiamiamo il metodo definito nella classe TextToSpeech.

$file_mp3 = "./files/$file_name.mp3";
//$file_ogg = "./files/$file_name.ogg";

?>

<br/><br/>
TTS: <?=$heckle?>
MP3: <?=$file_mp3?>
<br/>
<audio controls="controls" autoplay="autoplay" id="audio-mp3">
  <source src="<?=$file_mp3?>" type="audio/mp3" />
  <!--<source src="<?=$file_ogg?>" type="audio/ogg" />-->
  Your browser does not support the audio tag.
</audio> 

<br/><br/>

<hr class="space"/>

<form class="form" action="<?=$_SERVER['PHP_SELF']?>" method="get">
	<label>Heckle</label>
	<input type="text" class="text" name="heckle" maxlength="100" size="100" value=""/>
	<input type="submit" class="submit" value="TTS"/>
</form>


<input type="button" value="ascolta" onclick="prova()" />

<br/><br/>
<br/>



<?
//not using this...
//$tts->saveToFile("/var/www/vhosts/heckleonline.com/httpdocs/mp3/test.mp3");
?>

<div class="widget-wrap"><div class="widget widget_text">			<div class="textwidget">

</body>
</html>