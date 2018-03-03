<?php
	
	$hrs=date('H');

	$mins=date('i');
	
	if ($indHrs==21 || $indHrs==23) {
		if ($indMins>=55 && $indMins<=59) {
			$response=array('canPlay' => '1');
			echo json_encode($response);
		}
		else
		{
			$response=array('canPlay' => '0');
			echo json_encode($response);	
		}
	}
	else if ($indHrs==22 || $indHrs==24) {
		if ($indMins>=0 && $indMins<=1) {
			$response=array('canPlay' => '1');
			echo json_encode($response);
		}
		else
		{
			$response=array('canPlay' => '0');
			echo json_encode($response);	
		}
	}
	else
	{
		$response=array('canPlay' => '0');
		echo json_encode($response);	
	}

?>