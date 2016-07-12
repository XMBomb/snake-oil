<?php
include_once 'lib/simple_html_dom.php';
ini_set('max_execution_time', 3000);
$s = new ImageScraper();
$s->scrape();

/**
* ImageScraper
*/
class ImageScraper{
	
    public function scrape(){
    	$wordsFile = new SplFileObject('words.txt');
    	while (!$wordsFile->eof()) {
    		$word = trim($wordsFile->fgets());
    		$imageUrl = self::getImage($word);
    		$fileName = 'img/words/'.$word.'.jpg';
    		file_put_contents($fileName, file_get_contents($imageUrl));
    		sleep(1);
    	}
    }


	public static function getImage($searchKeyWord){
		$searchKeyWord=str_replace(' ','+',$searchKeyWord);
		$html = file_get_html("https://www.google.com/search?q=".$searchKeyWord."&tbm=isch");
		$resultImageSource = $html->find('img', 0)->src;
		return $resultImageSource;
	}
}