<?php

require_once(APP_BASE_PATH . "/constants/pmToolConstants.php");
require_once(APP_BASE_PATH . "/pmtools/PMToolBase.php");
require_once(APP_BASE_PATH . "/vendor/ptv5/PTClient.php");

class PivotalTrackerHelper extends PMToolBase
{
	private $objPT;

	private $_currentProjectDetails = null;

	function __construct()
	{
		$this->objPT = new PTClient(PM_TOOL_API_KEY, PM_TOOL_PROJECT_ID);
	}

	protected function getProjectDetails()
	{
		$this->_currentProjectDetails = $this->objPT->getProjectDetails();
		//print_r($this->_currentProjectDetails);
		return $this->_currentProjectDetails;
	}

	public function getCurrentIterationIdentifier()
	{
		$this->getProjectDetails();
		$iterationIdentifier = $this->_currentProjectDetails->current_iteration_number;
		//echo "<br><br>Iteration Identifier:<br>";
		//echo "".$iterationIdentifier;
		return $iterationIdentifier;
	}

	protected function getIterationDetails($iterationNumber)
	{
		$iterationDetails = $this->objPT->getIterationDetails($iterationNumber,"");
		return $iterationDetails;
	}

	private function getVerdictRGY($totalHours, $finishedHours, $currentIterationDetails)
	{
		$currentIterationLengthElapsedInPercentage = $this->getIterationLengthElapsedInPercentage($currentIterationDetails);		
		$currentIterationWorkDoneInPercentage = ceil($finishedHours/$totalHours * 100);
		//echo "Params: ". $currentIterationLengthElapsedInPercentage . "-". $currentIterationWorkDoneInPercentage;
		switch (true)
		{
			case ($currentIterationLengthElapsedInPercentage < PM_TOOL_ITERATION_TIME_ELAPSED_LAP1):
				return "G";
				break;
			case ($currentIterationLengthElapsedInPercentage < PM_TOOL_ITERATION_TIME_ELAPSED_LAP2):
				if($currentIterationWorkDoneInPercentage < PM_TOOL_ITERATION_WORK_DONE_LAP1)
					return "Y";
				else
					return "G";
				break;
			case ($currentIterationLengthElapsedInPercentage < PM_TOOL_ITERATION_TIME_ELAPSED_LAP3):
				if($currentIterationWorkDoneInPercentage < PM_TOOL_ITERATION_WORK_DONE_LAP1)
					return "R";
				elseif ($currentIterationWorkDoneInPercentage < PM_TOOL_ITERATION_WORK_DONE_LAP2)
					return "Y";
				else
					return "G";
				break;				
		}		
	}

	private function getIterationLengthElapsedInPercentage($currentIterationDetails)
	{
		$currentDayInIteration = ceil(abs((strtotime($currentIterationDetails->start) - (strtotime(strftime('%Y-%m-%d'))))  /60/60/24) +1);
		$currentDayInIterationPercentage = ceil(( $currentDayInIteration / ($this->_currentProjectDetails->iteration_length*7) )*100);
		return $currentDayInIterationPercentage;
	}

	public function processCurrentIterationAndGenerateRYGStatus()
	{		
		$currentIterationDetails = $this->getIterationDetails($this->getCurrentIterationIdentifier());

		//Processing Data from iteration
		$total_hours = 0;
		$completed_hours =0;

		
		foreach ($currentIterationDetails->stories as $story)
		{
			if(isset($story->estimate))
			{
				$total_hours = $total_hours + $story->estimate;	
			
				if ($story->current_state == "accepted" || $story->current_state == "finished" || $story->current_state == "delivered")
				{
					$completed_hours = $completed_hours + $story->estimate;
				}
			}
		}
		
		$status = $this->getVerdictRGY($total_hours,$completed_hours, $currentIterationDetails);
		return $status; 
	}
}

?>