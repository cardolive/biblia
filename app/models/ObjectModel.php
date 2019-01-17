<?php

class ObjectModel extends DB\SQL\Mapper {
    var $__table;
    var $__primaryKey;
    var $__db;
    var $__where;
    var $__whereParams;
    var $__order;
    var $__offset;
    var $__limit;

    public function __construct(DB\SQL $db, $table) {
	$this->__table = $table;
	$this->__db = $db;
	$this->__offset = 0;
	$this->__where = ' 1 = 1 ';
	$this->__whereParams = array();
        parent::__construct($db,$table);
    }

    public function where($expression, $value, $connect = 'and'){
	$this->__where .= " $connect $expression ";
	$this->__whereParams[] = $value;
	return $this;
    }

    public function in($expression, $array, $notIn = false){
	if(is_array($array) && !empty($array)){
		if($notIn){
			$this->__where .= " and $expression not in (";
		}else{
			$this->__where .= " and $expression in (";
		}
		for($i = 0; $i < sizeof($array) - 1; $i++){
			$this->where('?,', $array[$i], '');
		}
		$this->where('?', $array[$i], '');
		$this->__where .= ') ';
	}
	return $this;
    }

    public function between($expression, $value1, $value2, $connector = 'and'){
	    $this->__where .= " $connector $expression ";
	    $this->__whereParams[] = $value1;
	    $this->__whereParams[] = $value2;
	    return $this;
    }

    public function order($value){
	$this->__order = $value;
	return $this;
    }

    public function limit($value){
	$this->__limit = $value;
	return $this;
    }

    public function page($page){
	if(isset($this->__limit) && $this->__limit > 0){
		$this->__offset = ($this->__limit * $page) - 1;
	}
	return $this;
    }

    protected function heavyLoad(){
	$options = array();
	if(!empty($this->__order)){
		$options['order'] = $this->__order;
	}
	if(!empty($this->__limit)){
		$options['limit'] = $this->__limit;
	}
	$this->load(array_merge(array($this->__where), $this->__whereParams), $options);
    }

    public function one(){
	$this->heavyLoad();
	return $this->__getOne($this->query);
    }

    public function many(){
	$this->heavyLoad();
	return $this->query;
    }

    protected function __getOne($array){
        if(!is_array($array) || sizeof($array) != 1){
	    return null;
        }
        return $array[0];
    }
 
    public function all() {
        $this->load();
        return $this->query;
    }

    public function persist($data){
	    if(!is_array($data) || empty($data)){
		    return null;
	    }
	    if(isset($data[$this->__primaryKey]) && !empty($data[$this->__primaryKey])){
		$this->edit($data);
	    }else{
	    	$this->add($data);
	    }
    }

    public function add($data) {
	$this->setFields($data);
        $this->save();
    }
 
    public function getById($id) {
        $this->load(array($this->__primaryKey . '=?',$id));
	return $this->__getOne( $this->query );
    }

    public function filter($params){
	$this->load($params);
	return $this->query;
    }
 
    public function edit($data) {
        $this->load(array($this->__primaryKey . '=?',$data[$this->__primaryKey]));
	$this->setFields($data);
        $this->update();
    }

    public function setFields($array){
	foreach($this->fields() as $field){
		if(isset($array[$field])){
			$this->$field = $array[$field];
		}
	}
    }
 
    public function delete($id) {
        $this->load(array($this->__primaryKey . '=?',$id));
        $this->erase();
    }

    protected function __toArray($array){
	$result = array();
	foreach($array as $key => $value){
		if(is_array($value)){
			$result[$key] = $this->__toArray($value);
			continue;
		}
		if($value instanceof ObjectModel){
			$result[$key] = $value->toArray();
			continue;
		}
		$result[$key] = $value;
	}
	return $result;
    }

    public function toArray(){
	$result = array();
	if($this->dry()){
		return $result;
	}
	foreach($this->fields() as $field){
		if($this->$field instanceof ObjectModel){
			$result[$field] = $this->$field->toArray();
		}else if(is_array($this->$field)){
			$result[$field] = $this->__toArray($this->$field);
			/*
			foreach($this->$field as $item){
				if($item instanceof ObjectModel){
					$result[$field][] = $item->toArray();
				}else{
					$result[$field][] = $item;
				}
			}
			 */
		}else{
			$result[$field] = $this->$field;
		}
	}
	return $result;
    }
}

