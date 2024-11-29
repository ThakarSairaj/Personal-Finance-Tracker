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

$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$email = $_POST['email'];
$pass = $_POST['password'];
$country = $_POST['country'];
$phone = $_POST['phone_number'];
$bank_name = $_POST['bank_name'];
$acc_no = $_POST['bank_account_number'];
$credit_balance = $_POST['credit_balance'];


$value = mysqli_query($connection_establish, "SELECT * FROM user_register WHERE email = '$email';");

$does_exist = mysqli_num_rows($value);

if($does_exist > 0)
{
  $acc_exist_msg  = "This account already exist. Please Login";
  header("Location: sign_up.php?error=This user already exists. Please login.");
  exit();
}
else{
    $insert = "INSERT INTO `user_register` 
    (`fname`, `lname`, `email`, `password`,
     `country`, `ph_no`, `bank_name`, `bank_account`, `total_balance`) VALUES 
     ('$fname','$lname', '$email', '$pass', '$country', '$phone', '$bank_name', '$acc_no', '$credit_balance')";

    $query = mysqli_query($connection_establish, $insert);
    if($query)
    {
      $_SESSION['user_id'] = mysqli_insert_id($connection_establish);
      $_SESSION['email'] = $email;
      
        header("Location: home_main.php");
        exit();
    }
  else  {
    echo "Servers are Offline :(";
    }
}

mysqli_close($connection_establish);

?>