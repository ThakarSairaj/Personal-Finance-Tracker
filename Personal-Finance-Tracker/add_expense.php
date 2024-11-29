<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense - Finance Tracker</title>
    <link rel="stylesheet" href="home_main.css">
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
        <section class="form_section">
            <h2>Add New Expense</h2>
            <form action="submit_expense.php" method="POST">
                <div class="form_group">
                    <label for="expense_name">Expense Name:</label>
                    <input type="text" id="expense_name" name="expense_name" required>
                </div>
                <div class="form_group">
                    <label for="amount">Amount (₹):</label>
                    <input type="number" id="amount" name="amount" step="0.01" required>
                </div>
                <div class="form_group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form_group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Food">Food</option>
                        <option value="Transport">Transport</option>
                        <option value="Rent">Rent</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" name="notes" rows="4"></textarea>
                </div>
                <div class="form_group">
                    <button type="submit">Add Expense</button>
                </div>
            </form>
        </section>
    </main>
    <footer style="height: 30px;">
        <p >&copy; 2024 Finance Tracker. All rights reserved.</p>
    </footer>
</body>
</html>
