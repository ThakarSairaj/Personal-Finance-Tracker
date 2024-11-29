<?php
 

$connection_establish = mysqli_connect('localhost', 'root', '', 'trial');

/*if($con){
    echo "Yes Connected to the Database trail";
}
else{
    echo "Not connected";
}*/


$email = $_POST['login_email'];
$password = $_POST['login_password'];



//To Check weather the user email exists in the database already

$value = mysqli_query($connection_establish, "SELECT * FROM just WHERE email = '$email';");

$does_exist = mysqli_num_rows($value);
if($does_exist > 0)
{
    echo "This account is already registered kindly Login ";
}
else{
    $ins = "INSERT INTO `just` (`name`, `email`) VALUES ('$email', '$password')"; 
    $qry = mysqli_query($connection_establish, $ins);
    if($ins){
        echo "Inserted";
    }
    else{
        echo "Not Inserted";
    }
}





mysqli_close($connection_establish);
?>