<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


session_start();

$connection_established = mysqli_connect('localhost', 'root', '', 'user_database');

/*
if($connection_established)
{
    echo "Connection Establised";

}
else
{
    echo "Not Established";
}*/

$user_id = $_SESSION['user_id'];
$credit_amount = $_POST['credit_amount'];
$source = $_POST['source'];
$date = $_POST['date'];
$notes = $_POST['notes'];

$insert = "INSERT INTO credit (`user_id`,`amount`, `source`, `credited_date`, `notes`)VALUES
 ('$user_id','$credit_amount', '$source', '$date', '$notes')";
$query = mysqli_query($connection_established, $insert);

$fetch = "SELECT `total_balance` FROM user_register WHERE `user_id`=$user_id";
$retrive = mysqli_query($connection_established, $fetch);
$row = mysqli_fetch_assoc($retrive);
$curr_bal = $row['total_balance'];

$credit = $curr_bal + $credit_amount;

$update_bal = "UPDATE user_register SET `total_balance` = $credit WHERE `user_id` = $user_id";
mysqli_query($connection_established, $update_bal);

$user_email = $_SESSION['email'];
if($query)
{
   header("Location: home_main.php?msg=Credited");
   // Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host       = 'smtp.gmail.com';  // Set the SMTP server to send through
    $mail->SMTPAuth   = true;              // Enable SMTP authentication
    $mail->Username   = 'youremail@gmail.com'; // SMTP username
    $mail->Password   = '16 digits password from gmail settings';  // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;  // Enable TLS encryption
    $mail->Port       = 587;               // TCP port to connect to

    // Recipients
    $mail->setFrom('youremail@gmail.com');
    $mail->addAddress($user_email);  // Add a recipient (from session)

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Transaction Notification';
    $mail->Body    = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #555;
            line-height: 1.5;
            font-size: 16px;
        }
        .amount {
            font-weight: bold;
            color: #28a745; /* Green for credited amount */
            font-size: 18px;
        }
        .total {
            font-weight: bold;
            color: #007bff; /* Blue for total balance */
            font-size: 18px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaction Notification</h1>
        <p>Your recent transaction has been successfully credited to your account.</p>
        <p class="amount">Amount Credited: ' . $credit_amount . '</p>
        <p class="total">Total Balance: ' . $credit . '</p>
        
        <div class="footer">
            <p>Thank you for using our services!</p>
            <p>&copy; ' . date("Y") . ' Personal Finance Tracker </p>
        </div>
    </div>
</body>
</html>';

    // Send the email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


    exit();
}
else{
    echo "Servers are down";
}








mysqli_close($connection_established);
?>
