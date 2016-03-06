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
  //Pie chart data
  $strPieChartJson = $obj->getCurrentIterationStoriesStatusDataForPieChart();
  $strBurnDownChartRawData = $obj->getCurrentIterationStoriesStatusDataForBDChart();

  print '<pre>';
  if($strBurnDownChartRawData) {
    $arrBurnDownChartRawData = (explode(",",$strBurnDownChartRawData));
    /* burndown sorting */

    $arr_days_rec = array();

    if(is_array($arrBurnDownChartRawData) && count($arrBurnDownChartRawData) > 0) {
      foreach ($arrBurnDownChartRawData as $burn_key => $burn_val) {
        $burn_val = trim($burn_val, '[{"');
        $burn_val = trim($burn_val, '}');
        $burn_val = trim($burn_val, '}]');

        $arr_burn_val = explode('":',$burn_val);      
        $burn_time_stamp = strtotime(date('Y-m-d', strtotime($arr_burn_val[0]))); 

           

        $arr_days_rec[$burn_time_stamp] = @((int)($arr_days_rec[$burn_time_stamp]) + $arr_burn_val[1]);      
      }  

      if(count($arr_days_rec) > 0){         
        ksort($arr_days_rec);        
        $int_key = 0;
        $arr_final_burn = array();
        foreach ($arr_days_rec as $day_key => $day_val) { 
          $arr_final_burn[] = "{'x':".$int_key.",'y':".$day_val."}";
          $int_key++;
        }
        
      }
    }
  }

  /* END - burndown sorting */

?>


  <head>
    <meta charset="UTF-8">
    <title>Project ECG</title>
    <link rel="stylesheet" href="static/css/style.css">
    <!-- pie chart -->
      <script type="text/javascript">
          window.onload = function () {

            var pieChartData = JSON.parse('<?php echo $strPieChartJson; ?>');
            
            function getDataForPieChart(raw_data)
            {
              var retData = [];
              if(raw_data.finished >0)
              {
                retData.push({  y: raw_data.finished, name: "Completed", legendMarkerType: "triangle"});
              }
              if(raw_data.unfinsihed >0)
              {
                retData.push({  y: raw_data.unfinished, name: "ToDo", legendMarkerType: "square"}); 
              }
              if(raw_data.inprogress >0)
              {
                retData.push({  y: pieChartData.inprogress, name: "In Progress", legendMarkerType: "circle"});
              }
              
              return retData;
            }
            // Pie Chart Data Building
            pieFinalData= getDataForPieChart(pieChartData); 
            var chart = new CanvasJS.Chart("chartContainer",
            {
              title:{
                text: "Current Sprint Status",
                fontFamily: "arial black"
              },
                          animationEnabled: true,
              legend: {
                verticalAlign: "bottom",
                horizontalAlign: "center"
              },
              theme: "theme1",
              data: [
              {        
                type: "pie",
                indexLabelFontFamily: "Garamond",       
                indexLabelFontSize: 20,
                indexLabelFontWeight: "bold",
                startAngle:0,
                indexLabelFontColor: "MistyRose",       
                indexLabelLineColor: "darkgrey", 
                indexLabelPlacement: "inside", 
                toolTipContent: "{name}: {y}hrs",
                showInLegend: true,
                indexLabel: "#percent%", 
                dataPoints: pieFinalData
              }
              ]
            });
            chart.render();
          }
  </script>
  <script type="text/javascript" src="static/js/canvasjs/canvasjs.min.js"></script>

  </head>

  <body>
     <div class="intro">
         <h1>Project Health ECG</h1>
      </div>
      <div class="<?php echo $styleProjectHealth; ?>">

      </div>

      <div class="intro">
         <h1 style="padding-bottom: 0px; margin-bottom: 0px;">ECG (Burndown Chart)</h1>
      </div>
      <div style="width: 100%;">
        <div style="float: left;">
          <svg id="visualisation" width="650" height="500" class="chart"></svg>
        </div>
        <div style="float: left;">
          <div id="chartContainer" style="height: 300px; float: left;"></div>
        </div>
       </div> 
        
      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src='http://d3js.org/d3.v3.min.js'></script>
      <script src="static/js/index.js"></script>

<!--<svg id="visualisation" width="1000" height="500" class="chart"></svg>
      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src='http://d3js.org/d3.v3.min.js'></script>
      <script src="static/js/index.js"></script> -->
  </body>
</html>

