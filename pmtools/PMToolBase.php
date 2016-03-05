<?php

abstract class  PMToolBase
{

	abstract protected function getProjectDetails();

	abstract protected function getIterationDetails($iterationNumber);

	abstract protected function processCurrentIterationAndGenerateRYGStatus();

}


?>