<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'user_database');

$user_id = $_SESSION['user_id'];
$exp_amt = $_POST['me'];
$expense = $_POST['source'];
$doe = $_POST['date'];
$notes = $_POST['notes'];


$insert = "INSERT INTO month_exp(`user_id`, `exp_amt`, `expense`, `doe`, `notes`) VALUES 
('$user_id', '$exp_amt', '$expense', '$doe', '$notes')";

$query = mysqli_query($connection, $insert);

if($query)
{
    header("Location: home_main.php? added=Added to monthly Expense");
    exit();
}
else{
    echo "ERROR"; 
}

mysqli_close($connection);
?>
