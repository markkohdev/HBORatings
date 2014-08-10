<?php
//DBCache Updater
include("include/components.php");
include("PHPLinq.php");

class Movie {
	public $HBO;
	public $OMDB;

	//function __construct($title, $year, $genre, $OMDB, $shortsummary, $summary) {
	function __construct($HBO, $OMDB) {
		$this->HBO  = $HBO;
		$this->OMDB = $OMDB;
	} 
}

function cmpTitle($a, $b){
	return strcmp($a->HBO->title,$b->HBO->title);
}

function getOMDBData($title,$year){
	//Try to grab the movie with the title and year
	$omdbReqURL = "http://www.omdbapi.com/?t=".urlencode($title)."&y=".$year."&tomatoes=true";
	$omdbResponse = json_decode(file_get_contents($omdbReqURL));
	if(isset($omdbResponse->Response) && $omdbResponse->Response == "False") {
		//Maybe HBO has the year wrong (common), let's try it without the year
		$omdbReqURL = "http://www.omdbapi.com/?t=".urlencode($title)."&tomatoes=true";
		$omdbResponse = json_decode(file_get_contents($omdbReqURL));

		//TODO: If there's still no results, run a simple search and PHPLinq query to filter
		//the year.  Then grab that imdbID and query that against omdb
	}

	return $omdbResponse;
}

//Grab the movie list from HBO
$hbo_raw_xml = file_get_contents(HBO_MOVIE_LIST_URL);
if(!$hbo_raw_xml){
	echo("Error: Unable to retrieve movie list from HBO API.");
	die();
}

//Strip down the data to a useable format
$hbo_parsed_xml = simplexml_load_string($hbo_raw_xml);
$xml_movie_list = $hbo_parsed_xml->body->productResponses;
$movie_list = json_decode(json_encode($xml_movie_list))->featureResponse;

$movies_db = array();

//header('Content-Type: application/json');
//var_dump($xml_movie_list);
//echo(json_encode($json_movie_list));

foreach($movie_list as $item){
	
	$OMDB = getOMDBData($item->title,$item->year);

	$movie = new Movie($item,$OMDB);

	/*
	header('Content-Type: application/json');
	echo(json_encode($movie));
	var_dump($movie);
	die();
	*/

	$movies_db[] = $movie;

	//echo("$movie->HBO->title");
	echo("Pushed: ".$movie->HBO->title." (".$movie->HBO->year.") - ".$movie->OMDB->imdbRating.", ".$movie->OMDB->tomatoMeter."<br/>");

	//var_dump($movie);
	echo("<br/>");
}

//Sort the movies by title
usort($movies_db,'cmpTitle');

//header('Content-Type: application/json');
//echo(json_encode($movies));
file_put_contents(MOVIE_DB_FILENAME, json_encode($movies_db));

echo("Done.");

?>