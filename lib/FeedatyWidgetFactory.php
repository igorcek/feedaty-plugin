<?php 

class FeedatyWidgetFactory{
	
	private $curlCaller;
	
	public function __construct($curl){
		$this->curlCaller = $curl;
	}
	
	public function getWidgetCode($slug,$field){

		$details_widget = $this->curlCaller->getWidgets();

		return $details_widget->$slug->$field;
	}
	
}
