

<?php
	#Include section
	include_once("app_constants.php");
	
	include_once("./pmtools/PivotalTrackerHelper.php");

	#Pivotal tracker details
	#$ptApiToken = "4d7fcc93e974ab092b626e2e2854417d";
	#$ptProjectId = "1443874";

	#HTML Header
	echo "<html>";
	echo "	<head>";
	echo "		<title> ProjectECG </title>";
	echo "	</head>";

	#Processing data
	//echo "Story data: \n \n";

/*	$objPT = new PTClient($ptApiToken, $ptProjectId);
	//$stories = $objPT->getStories();
	$currentIterationNumber = $objPT->getProjectDetail()->current_iteration_number;
	//print_r($proj);
	$iteration = $objPT->getIterationDetail($currentIterationNumber,"");
	echo "<br><br><br>";
/*
	echo "Iteration Length: ". $proj->iteration_length ."<br/>";
	echo "Start date: ". $proj->start_date ."<br/>";
	echo "Current iteration: ". $proj->current_iteration_number ."<br/>";
*/
/*	echo "Iteration Length: ". $currentIterationNumber;
	
	echo "<br><br>Iteration details:<br>";
	print_r($iteration);

	
*/

	$obj = new PivotalTrackerHelper();

	$obj->processCurrentIterationAndGenerateRYGStatus();

	#HTML Footer
	echo "</html>";
?>

