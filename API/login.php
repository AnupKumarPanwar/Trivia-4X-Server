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

if (isset($_POST['phone']))
{
   
    $phone = mysqli_escape_string($conn, $_POST['phone']);
   
    $get_user_info = "SELECT username, balance, lives FROM users WHERE phone='$phone'";
    $result = mysqli_query($conn, $get_user_info);
    if (mysqli_num_rows($result) != 0)
    {
        $r=mysqli_fetch_assoc($result);
        $response = array(
            'result' => array(
                'status' => '1',
                'username' => $r['username'],
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
                'status' => '2'
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