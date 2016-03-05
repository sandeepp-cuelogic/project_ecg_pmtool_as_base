

<?php
	#Include section
	include_once("app_constants.php");
	include_once("./vendor/ptv5/Client.php");

	#Pivotal tracker details
	$ptApiToken = "4d7fcc93e974ab092b626e2e2854417d";
	$ptProjectId = "1443874";

	#HTML Header
	echo "<html>";
	echo "	<head>";
	echo "		<title> ProjectECG </title>";
	echo "	</head>";

	#Processing data
	echo "Story data: \n \n";

	$objPT = new PTClient($ptApiToken, $ptProjectId);
	$stories = $objPT->getStories();
	print_r($stories[0]);
	#HTML Footer
	echo "</html>";
?>

