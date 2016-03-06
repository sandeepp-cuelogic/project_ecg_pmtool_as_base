<?php
/**
 * This file is part of the ProjectECG PMTool As BAse component.
 *
 * @version 1.0
 * @copyright Copyright (c) 2016 Sandeep Paithankar
 * 
 */
include_once(APP_BASE_PATH . "/constants/pmToolConstants.php");
include_once(APP_BASE_PATH . "/vendor/ptv5/Client.php");
include_once(APP_BASE_PATH . "/pmtools/PivotalTrackerHelper.php");
//namespace ProjectECG\Helper;

/**
 * Helper class that interacts with opted Project Management Tool for gathering information
 *
 */

class PMToolHelper
{

	private $_selectedPMTool;

	private $_vendorPMTool;

	private $_projIterationLengthInWeeks;

	private $_projStartDate;

	private $_projectEndDate;



	function __construct($pmTool)
	{
		$this->_selectedPMTool = $pmTool;
		instantiatePMHelperObject();
	}

	private function instantiatePMHelperObject()
	{
		switch ($this->$_selectedPMTool)
		{
			case PM_TOOL_PIVOTALTRACKER:
				$this->_vendorPMTool = new PTClient(PM_TOOL_API_KEY, PM_TOOL_PROJECT_ID);
				break;
			case PM_TOOL_ATL_JIRA:
				
				break;
		}
	} 

	private function processCurrentIterationAndGenerateRYGStatus()
	{
		$iterationStatus = $this->_vendorPMTool->processCurrentIterationAndGenerateRYGStatus();
		$this->publishStatusToAWSIoT("", $iterationStatus);
	}

	private function publishStatusToAWSIoT($iotTopic, $status)()
	{
		$output = shell_exec('node ". APP_BASE_PATH ."/updateiothealth.js'. (($status=="Y")?"warning":(($status=="G")?"success":"error");
	}

	public function updateCurrentIterationHealth($projectIdentifier)
	{
		$
	} 
}
?>