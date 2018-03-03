<?php

// error_reporting(0);

require ('db.php');

$conn = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);

if (!$conn)
{
    $response = array(
        'result' => array(
            'status' => '0',
            'data' => 'Connection failed'
        )
    );
    die(json_encode($response));
}


   
   
    $get_leaderboard = "SELECT username, balance FROM users ORDER BY balance DESC LIMIT 50";
    $result = mysqli_query($conn, $get_leaderboard);
    if ($result)
    {
    	$response = array(
    	    'result' => array(
    	        'status' => '1',
    	        'data' => array()
    	    )
    	);

        while($r=mysqli_fetch_assoc($result))
        {
	        $response['result']['data'][]=$r;
   		}
        die(json_encode($response));
    }
    else
    {
        $response = array(
            'result' => array(
                'status' => '0',
                'data' => 'Connection failed.'
            )
        );
        die(json_encode($response));
    }


?>