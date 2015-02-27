<?php

/**
 * Audio file converter class
 * WMA 2 Ogg
 * MP3 2 Ogg
 *
 * @access public
 * @author Paul Scott
 * @copyright Paul Scott
 * @link http://directory.fsf.org/all/mp32ogg.html
 * @link http://www.mplayerhq.hu/design7/news.html
 * @link http://directory.fsf.org/OggEnc.html
 */

class audioconvert
{
	/**
	 * Constructor method, checks to see if necessary binaries exist
	 *
	 * @access public
	 * @param void
	 * @return exception on error
	 */
	public function __construct()
	{
		/*
if (!@file_exists('/usr/bin/mp32ogg'))
		{
			throw new Exception("Unable to locate MP32Ogg, please install it from the project site at http://directory.fsf.org/all/mp32ogg.html");
		}
		if (!@file_exists('/usr/bin/mplayer'))
		{
			throw new Exception("Unable to locate MPlayer, please install it from the project site at http://www.mplayerhq.hu/design7/news.html");
		}
		if (!@file_exists('/usr/bin/oggenc'))
		{
			throw new Exception("Unable to locate Oggenc, please install it from the project site at http://directory.fsf.org/OggEnc.html");
		}
		
*/
		
	}

	/**
	 * Method to encode an MP3 file to Ogg Vorbis format
	 *
	 * @param string $file
	 * @param bool string $delete
	 * @return void
	 */
	public function mp32OggFile($file, $delete = FALSE)
	{
		if(file_exists($file))
		{
			//$filename = basename($file);
			//$path = str_replace($filename, "",$file);
			//$res = @system("/usr/bin/mp32ogg $file $path");
			$res = @system("/usr/bin/mp32ogg $file");
			//shell_exec("/usr/bin/mp32ogg $file");
			
			if($delete == TRUE)
			{
				unlink($file);
			}
			return $res;
		}
		else {
			throw new Exception("File $file could not be found for conversion!");
		}

	}

	/**
	 * Method to convert a WMA (Windows Media File) to Ogg Vorbis Format
	 *
	 * @param string $file
	 * @return void
	 */
	public function wma2Ogg($file)
	{
		if(file_exists($file))
		{
			$filename = basename($file);
			$path = str_replace($filename, "",$file);
			chdir($path);
			@system("mplayer $file -ao pcm:file=$file.wav");
			@system("oggenc \"$file.wav\" ");
			unlink($file.".wav");
		}
		else {
			throw new Exception("File $file could not be found for conversion!");
		}
	}
}
?>