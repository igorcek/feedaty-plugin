<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
class FeedatyFileManager{
	private $cssFile;
	
	function __construct(){
		$this->cssFile = '/css/style.css';
	}
	
	public function saveCss($content){
		global $FEEDATY_PERCORSOPLUGIN;
		$file = fopen($FEEDATY_PERCORSOPLUGIN.$this->cssFile,'w');
		fwrite($file, $content);
		fclose($file);
	}
	
	public function getCss(){
		global $FEEDATY_PERCORSOPLUGIN;
		$filename = $FEEDATY_PERCORSOPLUGIN.$this->cssFile;
		$file = fopen($filename, 'r');
		$return = fread($file, filesize($filename));
		fclose($file);
		return $return;
	}
}
?>