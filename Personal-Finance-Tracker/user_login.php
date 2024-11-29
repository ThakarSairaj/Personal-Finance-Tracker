<?php
session_start();
$connection_establish = mysqli_connect('localhost', 'root', '', 'user_database');





/*if($connection_establish)
{
    echo "Connection Established";
}
else
{
    echo "Not Established";
}
*/

$user_id = $_SESSION['user_id'];
$email = $_POST['login_email'];
$password = $_POST['login_password'];

$value = mysqli_query($connection_establish, "SELECT * FROM user_register WHERE email = '$email';");

$does_exist = mysqli_num_rows($value);

if($does_exist > 0)
{
    $check = mysqli_fetch_assoc($value);
    if($password === $check['password'])
    {
        
            $_SESSION['user_id'] = $check['user_id'];
            $_SESSION['email'] = $email;
            header("Location: home_main.php");
            exit();
        
     
        
    }
    else
    {
        echo "Wrong Password";
    }
}
else{
    echo "EMAIL NOT FOUND. Kindly Register";
}

mysqli_close($connection_establish);

?>