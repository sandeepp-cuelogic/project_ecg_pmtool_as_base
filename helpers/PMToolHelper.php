<?php
/**
 * This file is part of the ProjectECG PMTool As BAse component.
 *
 * @version 1.0
 * @copyright Copyright (c) 2016 Sandeep Paithankar
 * 
 */
include_once(APP_BASE_PATH . "/constants/pmToolConstants.php");
include_once(APP_BASE_PATH . "/vendor/ptv5/PTClient.php");
include_once(APP_BASE_PATH . "/pmtools/PivotalTrackerHelper.php");
//namespace ProjectECG\Helper;

/**
 * Helper class that interacts with opted Project Management Tool for gathering information
 *
 */

class PMToolHelper
{

	public $_selectedPMTool=null;

	private $_vendorPMTool;

	private $_projIterationLengthInWeeks;

	private $_projStartDate;

	private $_projectEndDate;



	function __construct($pmTool)
	{
		$this->_selectedPMTool = $pmTool;
		$this->instantiatePMHelperObject();
	}

	private function instantiatePMHelperObject()
	{
		switch ($this->_selectedPMTool)
		{
			case PM_TOOL_PIVOTALTRACKER:
				$this->_vendorPMTool = new PivotalTrackerHelper();
				break;
			case PM_TOOL_ATL_JIRA:
				
				break;
		}
	} 

	private function processCurrentIterationAndGenerateRYGStatus()
	{
		$iterationStatus = $this->_vendorPMTool->processCurrentIterationAndGenerateRYGStatus();
		
		$this->publishStatusToAWSIoT("", $iterationStatus);
		return $iterationStatus;
	}

	private function publishStatusToAWSIoT($iotTopic, $status)
	{
		//$output = shell_exec('node ". APP_BASE_PATH ."/updateiothealth.js'. (($status=="Y")?"warning":(($status=="G")?"success":"error");
		
		$str_command = "nodejs ". APP_BASE_PATH ."/updateiothealth.js ". (($status=="Y")?"warning":(($status=="G")?"success":"error"));
		//$output = shell_exec($str_command);	
		return true;	
	}

	public function updateCurrentIterationHealth()
	{
		return $this->processCurrentIterationAndGenerateRYGStatus(PM_TOOL_PROJECT_ID);
	} 

	public function getCurrentIterationStoriesStatusDataForPieChart(){
		$json_data =$this->_vendorPMTool->processCurrentIterationStoriesAndGeneratePieData();
		return $json_data;
	}
}
?>