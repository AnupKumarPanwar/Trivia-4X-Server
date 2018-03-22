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

if (isset($_POST['username']))
{
   
    $username = mysqli_escape_string($conn, $_POST['username']);
   
    $add_reward = "UPDATE users SET lives=lives+1 WHERE username='$username'";
    $result = mysqli_query($conn, $add_reward);
    if ($result)
    {
        $response = array(
            'result' => array(
                'status' => '1'
            )
        );
        die(json_encode($response));
    }
    else
    {
        $response = array(
            'result' => array(
                'status' => '0'
            )
        );
        die(json_encode($response));
    }
}
else
{
    $response = array(
        'result' => array(
            'status' => '0',
            'data' => 'Some error occured.'
        )
    );
    die(json_encode($response));
}

?>