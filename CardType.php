<?php
	
abstract class CardType{
	const WORD = 'word';
	const CUSTOMER = 'customer';

	static function getConstants() {
	    $oClass = new ReflectionClass(__CLASS__);
	    return $oClass->getConstants();
	}
}