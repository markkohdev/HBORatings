<?php 
include("include/components.php"); 
include("sort_utils.php");

//Prepare the movie list
$MovieList = json_decode(file_get_contents(MOVIE_DB_FILENAME));

$default_sort = "imdb";
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : $default_sort;
switch($sort){
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
		//Default - Declared above
		usort($MovieList,$default_sort);
		break;
}

printHeader("Home | HBO Go Ratings");
?>
	<h3>Movies</h3>
	<ol>
		<?php
		foreach($MovieList as $movie){
			printMovie($movie);	
		}
		?>
	</ol>

<?php printFooter(); ?>