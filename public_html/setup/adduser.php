<?php 
session_start();

$user = $_POST['username'];
$pass = $_POST['password'];

function generatePassword($password)
    {
        // A higher "cost" is more secure but consumes more processing power
        $cost = 10;

        // Create a random salt
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // Prefix information about the hash so PHP knows how to verify it later.
        // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
        $salt = sprintf("$2a$%02d$", $cost) . $salt;

        // Value:
        // $2a$10$eImiTXuWVxfM37uY4JANjQ==

        // Hash the password with the salt
        $hash = crypt($password, $salt);

        return $hash;
    }

$host = $_SESSION['db_host'];
$username = $_SESSION['db_user'];
$password = $_SESSION['db_pass'];
$database = $_SESSION['db_name'];

$con = mysqli_connect($host, $username, $password, $database);
// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
$newpass =  generatePassword($pass);

// Perform queries
mysqli_query($con, "UPDATE `users` SET `user_name` = '$user', `user_password_hash` = '$newpass' WHERE user_id = '1'");
echo mysqli_error($con);

mysqli_close($con);

