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

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['referral']) && isset($_POST['password']))
{
    $username = mysqli_escape_string($conn, $_POST['username']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $referral = mysqli_escape_string($conn, $_POST['referral']);
    $password = mysqli_escape_string($conn, $_POST['password']);

    
    $check_if_email_already_registered = "SELECT username FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_if_email_already_registered);
    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'status' => '0',
                'data' => 'Email already exists'
            )
        );
        die(json_encode($response));
    }

    $check_if_already_registered = "SELECT username FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $check_if_already_registered);
    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'status' => '0',
                'data' => 'Username already exists'
            )
        );
        die(json_encode($response));
    }
    else
    {
        if (!empty($_POST['referral'])) {

            $find_referral_id="SELECT username FROM users WHERE username='$referral'";
            if (mysqli_num_rows(mysqli_query($conn, $find_referral_id))>0) {
                
                $otp=rand(100000, 999999);
                $signup_user = "INSERT INTO users (username, email, lives, password, otp, is_verified, referral) VALUES ('$username', '$email', 1, '$password', '$otp', 0, '$referral')";

                $result = mysqli_query($conn, $signup_user);

                // $incr_lives="UPDATE users SET lives=lives+1 WHERE username='$referral'";
                // $result2=mysqli_query($conn, $incr_lives);
                
                if ($result)
                {

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
                            'data' => 'Registration successful'
                        )
                    );
                    
                    die(json_encode($response));
                }
                else
                {
                    $response = array(
                        'result' => array(
                            'status' => '0',
                            'data' => 'Registration failed'
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
                        'data' => 'Invalid referral code'
                    )
                );
                die(json_encode($response));
            }
        }
        else
        {
            $otp=rand(100000, 999999);

            $signup_user = "INSERT INTO users (username, email, lives, password, otp, is_verified) VALUES ('$username', '$email', 0, '$password', '$otp', 0)";
            $result = mysqli_query($conn, $signup_user);
            
            if ($result)
            {
                $response = array(
                    'result' => array(
                        'status' => '1',
                        'data' => 'Registration successful'
                    )
                );
               
                die(json_encode($response));
            }
            else
            {
                $response = array(
                    'result' => array(
                        'status' => '0',
                        'data' => 'Registration failed'
                    )
                );
                die(json_encode($response));
            }   
        }

       
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