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
   
    $get_user_info = "SELECT balance, lives FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $get_user_info);
    if ($result)
    {
        $r=mysqli_fetch_assoc($result);
        $response = array(
            'result' => array(
                'status' => '1',
                'balance' => $r['balance'],
                'lives' => $r['lives']
            )
        );
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