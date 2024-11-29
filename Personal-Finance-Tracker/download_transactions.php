<?php
 // Include the FPDF library
require('FPDF/fpdf.php');
// Start the session and connect to the database
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'user_database');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch the recent transactions
$query = "SELECT * FROM (
            SELECT 'Expense' AS type, expense_name AS description, amount, date_of_expense AS date 
            FROM expense WHERE user_id='$user_id'
            UNION ALL
            SELECT 'Credit' AS type, source AS description, amount, credited_date AS date 
            FROM credit WHERE user_id='$user_id'
          ) AS transactions ORDER BY date DESC ";

$result = mysqli_query($connection, $query);

// Create a new PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Recent Transactions', 0, 1, 'C');

// Add a table header
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Date', 1);
$pdf->Cell(100, 10, 'Description', 1);
$pdf->Cell(40, 10, 'Amount', 1);
$pdf->Ln();

// Add table rows
$pdf->SetFont('Arial', '', 10);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(40, 10, htmlspecialchars($row['date']), 1);
        $pdf->Cell(100, 10, htmlspecialchars($row['description']), 1);
        $amount = ($row['type'] == 'Credit') ? '+' . htmlspecialchars($row['amount']) : '-' . htmlspecialchars($row['amount']);
        $pdf->Cell(40, 10, $amount, 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No transactions found.', 0, 1);
}

// Output the PDF
$pdf->Output('D', 'recent_transactions.pdf'); // Download the PDF

mysqli_close($connection);
?>
