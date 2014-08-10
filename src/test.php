<?php 
include("include/view_components.php"); 

function cmpTitle($a,$b){
	return strcmp($a->title, $b->title);
}

function cmpIMDBRating($a,$b){
	$a = $a->OMDB->imdbRating;
	$b = $b->OMDB->imdbRating;
	if(is_null($a) || is_null($b)) {
		if(is_null($a) && is_null($b))
			return 0;
		else if (is_null($a))
			return -1;
		else
			return 1;
	}
	$fa = (float)$a;
	$fb = (float)$b;
	if ($fa < $fb)
		return -1;
	else if ($fa > $fb)
		return 1;
	else
		return 0;
}

//Prepare the movie list
$MovieList = json_decode(file_get_contents(MOVIE_DB_FILENAME));


switch($_REQUEST['sort']){
	case "alpha":
		//Alphabetic
	usort($MovieList,'cmpTitle');
	break;
	case "ralpha":
		//Reverse alphabetic
	usort($MovieList,'cmpTitle');
	$MovieList = array_reverse($MovieList);
	break;
	case "imdb":
		//IMDB rating, highest to lowest
	usort($MovieList,'cmpIMDBRating');
	$MovieList = array_reverse($MovieList);
	break;
	case "rimdb":
		//IMDB rating, lowest to highest
	usort($MovieList,'cmpIMDBRating');
	break;
	default:
		//Default - Alphabetic
	usort($MovieList,'cmpTitle');
	break;
}

printHeader("Test Page");
?>
	<h3>Movies</h3>
	<ol>
		<?php
		foreach($MovieList as $movie){
			$HBO = $movie->HBO;
			echo("<li>$HBO->title");
			//var_dump($movie);
			echo("</li><br/><br/>");
		}
		?>
	</ol>

<?php printFooter(); ?>