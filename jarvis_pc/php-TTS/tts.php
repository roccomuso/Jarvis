<?php
// FileName: tts.php
/*
 *  A PHP Class that converts Text into Speech using Google's Text to Speech API
 *
 * Author:
 * Abu Ashraf Masnun
 * http://masnun.com
 *
 * Edited by:
 * Rocco Musolino
 * http://www.hackerstribe.com/chi-sono
 *
 */
 

class TextToSpeech {

    public $mp3data;   //è un attributo della classe
    //public $ogg;
    
    function __construct($text="") {

	//FOR MP3 TO OGG
    //require "audioconvert_class_inc.php";
       
        $text = trim($text);
        if(!empty($text)) {
            $text = urlencode($text);
            //http://translate.google.com/translate_tts?tl=en&q=text
            $this->mp3data = file_get_contents("http://translate.google.com/translate_tts?tl=en&q={$text}");
            //echo "data: " . $this->mp3data;
        }
    }
 
 
//////////////////////////////////////
//									//
// 	ONLY USING THIS SECTION OF TTS  //
//									//
//////////////////////////////////////
 
 
    function setText($text,$file_name,$path_dir) {  //definiamo un metodo per questa classe
        $text = trim($text);
        if(!empty($text)) {
			$testo_originale = $text;
            $text = urlencode($text);
            
            $this->mp3data = file_get_contents("http://translate.google.com/translate_tts?tl=it&q={$text}"); 
			
			$put_file = $path_dir.$file_name.".mp3";
			//echo "put: ". $put_file;
			file_put_contents($put_file, $this->mp3data);
			//chmod($put_file, 0777); 
			
			/*
			$convert = new audioconvert();
			$this->ogg = $convert->mp32OggFile($put_file,false);
			///var/www/vhosts/heckleonline.com/httpdocs/
			$put_file = "files/".$file_name.".ogg";
			file_put_contents($put_file, $this->ogg);
			chmod($put_file, 0777); 
			*/

         	
           //echo "data: " . $this->mp3data;            
           //return $mp3data;
		   
		   //Tracking of generated mp3, saving all the information in a xml file.
		   include("log.php");
		   
        } else { return false; }
    }
 
    function saveToFile($filename) {
        $filename = trim($filename);
        if(!empty($filename)) {
            return file_put_contents($filename,"files/".$this->mp3data);
        } else { return false; }
    }
 
}
?>