<?php
//DBCache Updater
include("include/components.php");
include("PHPLinq.php");

class Movie {
	public $title;
	public $year;
	public $genre;
	public $IMDBRating;
	public $RTRating;
	public $shortsummary;
	public $summary;

	function __construct($title, $year, $genre, $IMDBRating, $RTRating, $shortsummary, $summary) {
		$this->title = $title;
		$this->year = $year;
		$this->genre = $genre;
		$this->IMDBRating = $IMDBRating;
		$this->RTRating = $RTRating;
		$this->shortsummary = $shortsummary;
		$this->summary = $summary;
	} 
}

function cmpTitle($a, $b){
	return strcmp($a->title,$b->title);
}

function getIMDBRating($title,$year){
	$imdbReqURL = "http://www.omdbapi.com/?t=".urlencode($title)."&y=".$year;
	$imdbResponse = json_decode(file_get_contents($imdbReqURL));

	return $imdbResponse->imdbRating;
}

function getRTRating($title,$year){
	$RTReqUrl = RT_API_MOVIE_PREFIX.urlencode("$title $year");
	$RTResponse = json_decode(file_get_contents($RTReqUrl));

	if(count($RTResponse->movies) > 0) {
		return $RTResponse->movies[0]->ratings->critics_score;
	}
	else
		return null;
}


$hbo_raw_xml = file_get_contents(HBO_MOVIE_LIST_URL);
$hbo_parsed_xml = simplexml_load_string($hbo_raw_xml);
$xml_movie_list = $hbo_parsed_xml->body->productResponses->featureResponse;

$movies = array();

foreach($xml_movie_list as $item){
	
	$IMDBRating = getIMDBRating((string)$item->title,(string)$item->year);
	$RTRating = getRTRating((string)$item->title,(string)$item->year);

	$movie = new Movie((string)$item->title,(string)$item->year,(string)$item->primaryGenre,$IMDBRating,$RTRating,(string)$item->shortSummary,(string)$item->summary);

	$movies[] = $movie;

	echo("Pushed: $movie->title ($movie->year) - $movie->IMDBRating, $movie->RTRating<br/>");
	//var_dump($movie);
	echo("<br/>");
}

usort($movies,'cmpTitle');

$filename = "moviecache.json";

//echo(json_encode($movies));
file_put_contents($filename, json_encode($movies));

echo("Done.");

?>