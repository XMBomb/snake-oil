<?php

/**
* Card
*/
class Card implements JsonSerializable{
	private $name;
	private $type;

	function __construct($name, $type){
		$this->name = $name;
		$this->type = $type;
	}

	public function jsonSerialize(){
		return array(
			'name' => $this->getName(),
			'type' => $this->getType(),
		);
	}

	/**
	* Gets the value of name.
	*
	* @return mixed
	*/
	public function getName() { return $this->name; }

	/**
	* Sets the value of name.
	*
	* @param mixed $name the name
	*
	* @return self
	*/
	public function setName($name){ $this->name = $name; }

	/**
	* Gets the value of type.
	*
	* @return mixed
	*/
	public function getType() { return $this->type; }

	/**
	* Sets the value of type.
	*
	* @param mixed $type the type
	*
	* @return self
	*/
	public function setType($type){ $this->type = $type; }

}
