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

if (isset($_POST['email']) && isset($_POST['otp']))
{
   
    $email = mysqli_escape_string($conn, $_POST['email']);
    $otp = mysqli_escape_string($conn, $_POST['otp']);

    $find_user="SELECT username FROM users WHERE email='$email' and otp='$otp'";
    $res=mysqli_query($conn, $find_user);

    if (mysqli_num_rows($res)==1) {
       
        $verify_user = "UPDATE users SET is_verified=1 WHERE email='$email'";
        $result = mysqli_query($conn, $verify_user);

        $get_referral_query="SELECT referral FROM users WHERE email='$email' AND referral IS NOT null";
        $get_referral=mysqli_query($conn, $get_referral_query);

        if (mysqli_num_rows($get_referral)==1) {
            $r1=mysqli_fetch_assoc($get_referral);
            $r2=$r1['referral'];

            $update_lives_query="UPDATE users SET lives=lives+1 WHERE username='$r2'";
            $r3=mysqli_query($conn, $update_lives_query);
        }



          if ($result)
          {
            $r=mysqli_fetch_assoc($res);
              $response = array(
                  'result' => array(
                      'status' => '1',
                      'username' => $r['username'],
                      'data' => 'Verification successful.'
                  )
              );
              die(json_encode($response));
          }
          else
          {
              $response = array(
                  'result' => array(
                      'status' => '0',
                      'data' => 'Verification failed.'
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
                'data' => 'Verification failed.'
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