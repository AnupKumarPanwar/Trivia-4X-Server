<?php
	
	$hrs=date('H');

	// $indHrs=($hrs+5)%24;
	$indHrs=$hrs;

	// echo $hrs."<br>";
	// echo $indHrs."<br>";


	$mins=date('i');
	// $indMins=($mins+30)%60;
	$indMins=$mins;

	// echo $indMins."<br>";
	
	if ($indHrs==12 || $indHrs==14) {
		if ($indMins>=56 && $indMins<=59) {
			$response=array('canPlay' => '1');
			echo json_encode($response);
		}
		else
		{
			$response=array('canPlay' => '0');
			echo json_encode($response);	
		}
	}
	elseif ($indHrs==13 || $indHrs==14) {
		if ($indMins<=1) {
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