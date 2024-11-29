<?php
session_start();

// Connect to the database
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

// Fetch the total_balance for the logged-in user
$query = "SELECT total_balance  FROM user_register WHERE user_id = $user_id";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_balance = $row['total_balance'];
} else {
    $total_balance = 0; // Default value if query fails
}


// Format the total balance for display
$total_balance_formatted = '₹' . number_format($total_balance, 2);
$balance_background_color = ($total_balance > 1000) ? 'green' : '#C30101'; // 


//TO FETCH THE DATA IN THE RECENT TRANSACTION

// Fetch the 5 most recent expenses and credits
// Fetch the 5 most recent expenses and credits
$expense_query = "SELECT 'Expense' AS type, expense_name AS description, amount, date_of_expense AS date 
                  FROM expense WHERE user_id='$user_id' ORDER BY date_of_expense DESC LIMIT 5";

$credit_query = "SELECT 'Credit' AS type, source AS description, amount, credited_date AS date 
                 FROM credit WHERE user_id='$user_id' ORDER BY credited_date DESC LIMIT 5";

// Combine both queries using UNION
$query = "($expense_query) UNION ($credit_query) ORDER BY date DESC LIMIT 5";
$transaction_color = ($row['type'] == 'Credit') ? 'green': 'red';
$result = mysqli_query($connection, $query);



/*MONTHLY EXPENSE */
// TO FETCH THE MONTHLY EXPENSES
$monthly_expense_query = "SELECT exp_amt, expense, doe, notes FROM month_exp WHERE user_id = $user_id";
$monthly_expense_result = mysqli_query($connection, $monthly_expense_query);


mysqli_close($connection);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker Home</title>
    <link rel="stylesheet" type="text/css" href="home_main.css">
</head>
<body>

    <header>
        <div class="container">
            <div class="logo">
                <h1>Finance Tracker</h1>
            </div>
            <nav>
                <ul class="nav_links">
                    <li><a href="home_main.php">Dashboard</a></li>
                    <li><a href="add_expense.php">Add Expense</a></li>
                    <li><a href="credit_bal.html">Credit Amount</a></li>
                    <li><a href="monthlyexp.html">Monthly Expense</a></li>
                   
                </ul>
            </nav>
        </div>
    </header>

    <main>
    <section class="balance_overview" style="margin-top: -25px; background-color: <?php echo $balance_background_color; ?>;">
        <h2 style="color:white;">Current Balance</h2>
        <p style="color:white; font-size: 20px;"><?php echo htmlspecialchars($total_balance_formatted); ?></p>
    </section>

        <section class="overview_grid">
        <div class="overview_item">
    <h3>Monthly Expenses Breakdown</h3>
    <ul>
        <?php
        // Check if there are any expenses
        if ($monthly_expense_result && mysqli_num_rows($monthly_expense_result) > 0) {
            // Loop through the result and display each expense
            while ($expense_row = mysqli_fetch_assoc($monthly_expense_result)) {
                echo "<li>" . htmlspecialchars($expense_row['doe']) . " - " . htmlspecialchars($expense_row['expense']) . ": ₹" . htmlspecialchars($expense_row['exp_amt']);
                if (!empty($expense_row['notes'])) {
                    echo " (" . htmlspecialchars($expense_row['notes']) . ")";
                }
                echo "</li>";
            }
        } else {
            echo "<li>No monthly expenses added yet.</li>";
        }
        ?>
    </ul>
</div>


            <div class="overview_item recent_transactions">
    <h3>Recent Transactions</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php
                        // Loop through the result and display each transaction
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              /*  echo "<tr>"; // Opening <tr> tag
                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['type']) . ": " . htmlspecialchars($row['description']) . "</td>";*/
                                // Determine the sign for the amount based on transaction type
                                if ($row['type'] == 'Credit') {
                                    echo "<tr style= 'color: #70e000';>"; // Opening <tr> tag
                                    echo "<td style= 'color: #70e000';> " . htmlspecialchars($row['date']) . "</td>";
                                    echo "<td style= 'color: #70e000';>" . htmlspecialchars($row['type']) . ": " . htmlspecialchars($row['description']) . "</td>";
                                    echo "<td style= 'color: #70e000';>+" . htmlspecialchars($row['amount']) . "</td>";
                                } else {
                                    echo "<tr style= 'color: red';>"; // Opening <tr> tag
                                    echo "<td style= 'color: red';> " . htmlspecialchars($row['date']) . "</td>";
                                    echo "<td style= 'color: red';>" . htmlspecialchars($row['type']) . ": " . htmlspecialchars($row['description']) . "</td>";
                                    echo "<td style= 'color: red';>-" . htmlspecialchars($row['amount']) . "</td>";
                                }
                                echo "</tr>"; // Closing </tr> tag
                            }
                        } else {
                            // Handle the case when no results are returned
                            echo "<tr><td colspan='3'>No transactions found.</td></tr>";
                        }
                        ?>
                        
        </tbody>
        
    </table>
    <center>

<button class="btn_pdf" style="background-color: #1a759f; margin-top: 15px; padding: 10px 20px; color: white; border: none; border-radius: 5px; cursor: pointer;">
    
    <a href="download_transactions.php" class = "linkpdf" style="color: white; font-size: 15px;">Download Recent Transactions</a>
</button>
</center>
</div>


            <div class="overview_item">
                <h3>Budget Overview</h3>
                <p>You are on track with your monthly budget.</p>
            </div>

            <div class="overview_item">
                <h3>Accounts Overview</h3>
                <ul>
                    <li>Savings: $5,000</li>
                    <li>Checking: $3,000</li>
                    <li>Investments: $2,500</li>
                </ul>
            </div>

            <div class="overview_item">
                <h3>Alerts & Notifications</h3>
                <p>You have a bill due in 3 days.</p>
            </div>
        </section>
    </main>

    
</body>
</html>
