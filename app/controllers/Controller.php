<?php
class Controller{

	protected $f3;
	protected $db;

	function beforeroute(){
		//echo 'Antes da rota ';
	}
	function afterroute(){
		//echo ' Depois da rota';
	}


	function __construct() {
		
		$f3=Base::instance();
		$this->f3=$f3;

	    $db=new DB\SQL(
	        $f3->get('JFAdb'),
	        $f3->get('JFAun'),
	        $f3->get('JFApw'),
	        array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
	    );

	    $this->db=$db;
	}
}