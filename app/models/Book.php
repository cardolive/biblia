<?php
class Book extends ObjectModel {

	var $capitulos;
 
	public function __construct(DB\SQL $db) {
	    parent::__construct($db,'book');
	}
	
	public function tudo() {
	    $this->load();
	    return $this->query;
	}

	public function porId($id) {
	    $this->load(array('id=?',$id));
	    return $this->query;
	}
	
	public function porTestamento($tes) {
	    $this->load(array('testamento=?',$tes));
	    return $this->query;
	}
	
	public function loadCapitulos(){
		$this->capitulos = $this->__db->exec("select distinct chapter from verse where book_id = ? order by 1", $this->id);
	}
}
