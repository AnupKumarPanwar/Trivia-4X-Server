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

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (isset($_POST['email']))
{

    $email=mysqli_escape_string($conn, $_POST['email']);
   
    $otp=rand(100000, 999999);

    $update_otp="UPDATE users SET otp='$otp' WHERE email='$email'";

    if (mysqli_query($conn, $update_otp)) { 


    $to = $email;
    $subject = "Trivia 4X Verification Email";
    $message = '
    <html>
    <head>
    <title>Trivia 4X - Live Trivia & Quiz Game Show</title>
    </head>
    <body>
    <h2>Thank you for joining Trivia 4X</h2>
    <p>Use the following OTP to verify your email. <br/></p>
    <b>'.$otp.'</b>
    <br/>
    <br/>
    <p>Trivia 4X Inc.</p>
    </body>
    </html>
    ';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // More headers
    $headers.= 'From: <no-reply@trivia4x.com>' . "\r\n";
    $headers.= 'Bcc: 1anuppanwar@gmail.com' . "\r\n";
    mail($to, $subject, $message, $headers);



      
              $response = array(
                  'result' => array(
                      'status' => '1',
                      'data' => 'OTP sent successful.'
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