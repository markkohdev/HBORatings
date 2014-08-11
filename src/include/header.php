<?php
	if( !isset($title)){
		$title = "HBO GO Ratings";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo($title); ?></title>

		<?php include("libs-css.php"); ?>

	</head>
	<body>

		<div class="container-narrow">

		<div class="masthead">
			<ul class="nav nav-pills pull-right">
				<li><a href="index.php?sort=alpha">Alphabetic</a></li>
				<li><a href="index.php?sort=imdb">IMDB Rating</a></li>
			</ul>
			<h3 class="muted"><a href="index.php"><img src="img/logo_245x89.png" alt="HBO Go Ratings Logo" /></a></h3>
		</div>

		<hr>
