<?php
class Verse extends ObjectModel{

	var $versiculos;
	var $nomeLivro;

	public function __construct(DB\SQL $db) {
	    parent::__construct($db,'verse');
	}
	
	public function tudo() {
	    $this->load();
	    return $this->query;
	}

	public function porId($id) {
	    $this->load(array('id=?',$id));
	    return $this->query;
	}
	
	public function porLivroId($id) {
	    $this->load(array('book_id=?',$id));
	    return $this->query;
	}
	
	public function porLivroIdCapitulo($id,$ch) {
		//echo '<pre>';
		//echo ' Verse -> porLivroIdCapitulo';
	   	//echo ' Qual id? '.$id;
    		//echo ' Qual cap? '.$ch;
    		//echo '</pre>';

	$this->where('book_id = ? and chapter = ?', array($id, $ch) );
	return $this;
	}
	
	public function loadVersiculos(){
		$this->versiculos = $this->__db->exec("select distinct verse from verse where book_id = ? and chapter = ? order by 1", $this->id, cap);
	}
	
	public function resultadoBusca($termo){
		$this->where('lower(text) like ?', strtolower($termo));
		return $this;
	}
}
