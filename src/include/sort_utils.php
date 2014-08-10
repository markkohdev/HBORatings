<?php

function cmpTitle($a,$b){
	return strcmp($a->HBO->title, $b->HBO->title);
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

?>