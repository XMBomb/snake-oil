<?php
function __autoload($class_name) {
	require_once $class_name . '.php';
}

$snakeOil = new SnakeOil();

/**
* sf
*/
class SnakeOil{
	const BAD_REQUEST_CODE = 400;
	const SERVER_ERROR = 500;
	private $cards = array();

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
			$this->cards[CardType::WORD][] = new \Card(trim($wordsFile->fgets()), CardType::WORD);
		}

		$customersFile = new SplFileObject($filesToRead[1]);

		while (!$customersFile->eof()) {
			$this->cards[CardType::CUSTOMER][] = new \Card(trim($customersFile->fgets()), CardType::CUSTOMER);
		}
	}

	private function shuffleCards(){
		shuffle($this->cards[CardType::CUSTOMER]);
		shuffle($this->cards[CardType::WORD]);
	}


	private function processRequest(){
		if(isset($_GET['word']) && !empty($_GET['word'])){
			return $this->getCards($_GET['word'], CardType::WORD);
		}

		if(isset($_GET['customer']) && !empty($_GET['customer'])){
			return $this->getCards($_GET['customer'], CardType::CUSTOMER);
		}
	}

	private function respond($cards){
		header('Content-Type: application/json');
		echo json_encode(array(
			'cards' => $cards
		));
	}

	private function getCards($number, $cardType){
		$cards = array();
		for ($i=0; $i < $number; $i++) { 
			$cards[] = $this->cards[$cardType][$i];
		}
		return $cards;
	}
}
