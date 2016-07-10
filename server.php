<?php

$snakeOil = new SnakeOil();

/**
* sf
*/
class SnakeOil{
	const BAD_REQUEST_CODE = 400;
	const SERVER_ERROR = 500;
	private $wordCards = array();
	private $customerCards = array();

	function __construct(){
		try{
			$this->readConfig();
			$this->shuffleCards();
			$cards = $this->processRequest();
			$this->respond($cards);
		}catch(Exception $e){
			http_response_code(self::SERVER_ERROR);
			echo 'Internal Server Error!';
		}
	}

	private function readConfig(){
		$filesToRead = array(
			'words.txt',
			'customers.txt'
		);

		$wordsFile = new SplFileObject($filesToRead[0]);

		while (!$wordsFile->eof()) {
			$this->wordCards[] = trim($wordsFile->fgets());
		}

		$customersFile = new SplFileObject($filesToRead[1]);

		while (!$customersFile->eof()) {
			$this->customerCards[] = trim($customersFile->fgets());
		}
	}

	private function shuffleCards(){
		shuffle($this->wordCards);
		shuffle($this->customerCards);
	}


	private function processRequest(){
		if(isset($_GET['newWordCard']) && !empty($_GET['newWordCard'])){
			return $this->getWordCards($_GET['newWordCard']);
		}

		if(isset($_GET['newCustomerCard']) && !empty($_GET['newCustomerCard'])){
			return $this->getCustomerCards($_GET['newCustomerCard']);
		}
	}

	private function respond($cards){
		header('Content-Type: application/json');
		echo json_encode(array(
			'cards' => $cards
		));
	}

	private function getWordCards($number){
		$words = array();
		for ($i=0; $i < $number; $i++) { 
			$words[] = $this->wordCards[$i];
		}
		return $words;
	}


	private function getCustomerCards($number){
		$customers = array();
		for ($i=0; $i < $number; $i++) { 
			$customers[] = $this->customerCards[$i];
		}
		return $customers;
	}
}