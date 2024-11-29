<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

session_start();

// Connect to the database
$connection = mysqli_connect('localhost', 'root', '', 'user_database');


$user_id = $_SESSION['user_id'];
$expense_name = $_POST['expense_name'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$category = $_POST['category'];
$notes = $_POST['notes'];

$insert = "INSERT INTO expense(`user_id`,`expense_name`,`amount`,`category`,`date_of_expense`,`description`) 
VALUES ('$user_id','$expense_name', '$amount', '$category', '$date', '$notes')";

$query = mysqli_query($connection, $insert);

//$expense_amount = "SELECT `amount FROM expense WHERE user_id='$user_id'";
$total_balance = "SELECT `total_balance` FROM user_register WHERE user_id='$user_id'";
$fetch_val = mysqli_query($connection, $total_balance);
$row = mysqli_fetch_assoc($fetch_val);
$exp_amt = $row['total_balance'];
$amount_after_expense = $exp_amt - $amount;

$updated_balance = "UPDATE user_register SET `total_balance` = $amount_after_expense where `user_id` = '$user_id'";

$user_email = $_SESSION['email'];
mysqli_query($connection, $updated_balance);
if($query){
    header("Location: home_main.php?s_msg: added successfully");
    
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
            color: #C30101; /* Green for credited amount */
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
        <p>A transaction has been processed and the amount has been debited from your account.</p>
        <p class="amount">Amount Debited: ' . $amount . '</p>
        <p class="total">Total Balance: ' . $amount_after_expense . '</p>
        
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



/*
$to = $user_email;
$subject = "Regarding Tansaction";
$msg = "There was a transaction made Thankyou";
$header = "no-reply ft@gmail.com";
mail($to, $subject, $msg, $header);

mysqli_close($connection);*/

?>