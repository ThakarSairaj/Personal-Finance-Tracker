<?php

$connection = mysqli_connect('localhost', 'root', '', 'user_database');


$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$submit = "INSERT into contact_us(`name`, `email`, `message`) values ('$name', '$email', '$message')";

$post = mysqli_query($connection, $submit);

if($post)
{
    header("Location: contact.php?success_msg=Submitted Successfully" );
    exit();
}
else{
    echo "There is an internal server problem";
}

mysqli_close($connection);
?>
