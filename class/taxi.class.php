<?php 
class Taxi {
	public $id;
	public $lat;
	public $lon;
	public $data;

	public function __construct($mixed) {
			$this->id = $mixed->id;
			$this->lat = $mixed->position->lat;
			$this->lon = $mixed->position->lon;
			$this->data = $mixed;
	}

	public function getCoordinate() {
		return array(
			"lat"=>$this->lat,
		 	"lon"=>$this->lon
		);
	}

}