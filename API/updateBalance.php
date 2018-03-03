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

if (isset($_POST['username']) && isset($_POST['amount']))
{
   
    $username = mysqli_escape_string($conn, $_POST['username']);
    $amount = mysqli_escape_string($conn, $_POST['amount']);

   
    $add_reward = "UPDATE users SET balance=balance+'$amount' WHERE username='$username'";
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