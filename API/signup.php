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

if (isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['referral']) && isset($_POST['email']))
{
    $username = mysqli_escape_string($conn, $_POST['username']);
    $phone = mysqli_escape_string($conn, $_POST['phone']);
    $referral = mysqli_escape_string($conn, $_POST['referral']);
    $email = mysqli_escape_string($conn, $_POST['email']);

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
                
                $signup_user = "INSERT INTO users (username, phone, lives, email) VALUES ('$username', '$phone', 1, '$email')";

                $result = mysqli_query($conn, $signup_user);

                $incr_lives="UPDATE users SET lives=lives+1 WHERE username='$referral'";
                $result2=mysqli_query($conn, $incr_lives);
                
                if ($result && $result2)
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
            $signup_user = "INSERT INTO users (username, phone, lives, email) VALUES ('$username', '$phone', 0, '$email')";
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