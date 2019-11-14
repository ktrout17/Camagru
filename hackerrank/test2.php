<?php
	$sentence = "The lines are printed in reverse order.";
	$chop = chop($sentence, ".");
	$explode = explode(" ", $chop);
	// $sort = asort($explode);
	$implode = implode($explode);
	print_r($implode);
?>