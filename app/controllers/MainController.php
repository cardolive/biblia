<?php
class MainController extends Controller{
	
	function render($f3) {
         	echo \Template::instance()->render('template.htm');
        //var_dump($book[0]->nome);
    	//$result = $this->db->exec("select lala");
    	//$f3->set('resultado', $result);
    	}
    
	function listaLivros(){
	    	$book = new Book($this->db);
	    	$books = $book->tudo();
	    	
	    	$this->f3->set('livros', $books);
	    	
	    	echo \Template::instance()->render('livros.htm');
	}
	    
	      function listaCapitulos($f3,$params){
	    	$book = new Book($this->db);
	    	$books = $book->porId($params['id']);
	    	$books[0]->loadCapitulos();
	    	
	    	$this->f3->set('livro', $books[0]);
	    	
	    	echo \Template::instance()->render('capitulos.htm');
	    }
	    
	     function listaVersiculos($f3,$params){
	    	$verse = new Verse($this->db);
	    	$verses = $verse->porLivroIdCapitulo($params['id'], $params['cap'])->many();
	    	
	    	//echo '<pre>';
	    	//echo ' MainController -> listaVersiculos ';
	    	//echo ' Qual id? '.$params['id'];
	    	//echo ' Qual cap? '.$params['cap'];
	    	//var_dump($verses);
	    	//echo '</pre>';
	    	
	    	$this->f3->set('versiculos', $verses);
	    	
	    	$books = new Book($this->db);
	    	$book = $books->porId($params['id']);
	    	$book[0]->loadCapitulos();
		$this->f3->set('livro', $book[0]);
	    	
	    	echo \Template::instance()->render('versiculos.htm');
	    }
	    
	    function listaRespostas(){
	    	//echo '<pre>';
	    	//echo ' MainController -> listaRespostas ';
	    	//var_dump($_POST);
	    	//echo '</pre>';
	    	$termo = $_GET['termo'];

	    	//var_dump($_GET);
	    	
	    	$verse = new Verse($this->db);
	    	$verses = $verse->resultadoBusca('%' . $termo . '%')->order('book_id, chapter, verse')->many();
	    	
	    	$this->f3->set('versiculos', $verses);
	    	$this->f3->set('termo', $termo);
	    	
	    	$book = new Book($this->db);
	    	$livro;
	    	if (!empty($verses)){

	    		if(sizeof($verses)<502){

			    	foreach ($verses as $value) {
		    			$livro =  $book->porId($value['book_id']);
		    			$nome_livro = array_column($livro, 'nome');
		    			$value['nomeLivro'] = $nome_livro[0];
					} 
					echo \Template::instance()->render('resultado_busca.htm');	

				}else{
					echo \Template::instance()->render('template.htm');	
					echo '<pre>Resultado maior que 500 ocorrencias!</pre>';
				}
				    		
	    	}else{
	    		echo \Template::instance()->render('template.htm');	
	    	}
	    }

}