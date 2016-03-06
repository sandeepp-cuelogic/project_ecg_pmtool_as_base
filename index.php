<!DOCTYPE html>
<html >

<?php
	#Include section
	include_once("app_constants.php");
	
	include_once("./pmtools/PivotalTrackerHelper.php");
	include_once("./helpers/PMToolHelper.php");

	

	//$obj = new PivotalTrackerHelper();
	$obj = new PMToolHelper(PM_TOOL_PIVOTALTRACKER);
	$iterationStatus = $obj->updateCurrentIterationHealth();
	// $setProjectHealth = "<input type='hidden' value='$iterationStatus'>";
	if($iterationStatus == "G"){
		$styleProjectHealth= "prjhealth hgreen";
	}elseif($iterationStatus == "Y"){
	 	$styleProjectHealth= "prjhealth hamber";
	//$obj->processCurrentIterationAndGenerateRYGStatus();	
	}else{
		$styleProjectHealth= "prjhealth hred";
	}
?>


  <head>
    <meta charset="UTF-8">
    <title>Project ECG</title>
    <link rel="stylesheet" href="/static/css/style.css">
  </head>

  <body>
  		<? echo $setProjectHealth; ?>
      <div class="intro">
         <h1>Project Health ECG</h1>
      </div>

      <div class= "<?php echo $styleProjectHealth; ?>"  >

      </div>

      <div class="intro">
         <h1 style="padding-bottom: 0px; margin-bottom: 0px;">ECG (Burndown Chart)</h1>
      </div>
      <svg id="visualisation" width="1000" height="500" class="chart"></svg>
      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src='http://d3js.org/d3.v3.min.js'></script>
      <script src="/static/js/index.js"></script>
  </body>
</html>

