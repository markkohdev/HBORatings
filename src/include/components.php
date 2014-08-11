<?php
set_include_path(get_include_path().PATH_SEPARATOR.'/home1/markkoh3/public_html/hboratings.com/include/');

//Include for every page
include("constants.php");
//include("PHPLinq.php");

function printHeader($title){
	include("header.php");
}

function printFooter() {
	include("footer.php");
}

function printMovie($movie) {
	//Grab the child aggregations
	$HBO = $movie->HBO;
	$OMDB = $movie->OMDB;
	
	if (is_null($OMDB->imdbRating)) {
		$IMDB_display = "N/A";
		$IMDB_href = "#";
	}
	else {
		$IMDB_display = "$OMDB->imdbRating/10.0";
		$IMDB_href = "http://imdb.com/title/$OMDB->imdbID";
	}
	if (is_null($OMDB->tomatoMeter)) {
		$RT_display = "N/A";
		$RT_href = "#";
	}
	else {
		$RT_display = "$OMDB->tomatoMeter%";
		$RT_href = "#";
	}

	?>
	
		<li class="row">
			<span class="span3"><?php echo("$HBO->title ($HBO->year)");?></span>
			<span class="span2"><a href="<?php echo($IMDB_href);?>" target="_blank"><span class="imdb_logo"></span><?php echo($IMDB_display);?></a></span>
			<span class="span2"><a href="<?php echo($RT_href);?>" target="_blank"><span class="rt_logo"/></span><?php echo($RT_display); ?></a></span>
		</li>
		<?php
}
