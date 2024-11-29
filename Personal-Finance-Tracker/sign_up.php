<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sign_up.css">
    <style>
        .error { color: red; font-size: 12px; margin-top: -9px; }
        .hidden { display: none; }
    </style>
    <title>Multi-step Registration</title>
</head>
<body>
    <form id="registration_form" action="user_authentication.php" method="post">
        <div class="reg" id="user_info">
            <label class="reg_lbl">Register</label>
            <input type="text" placeholder="First Name" class="in_reg" name="first_name" required>
            <input type="text" placeholder="Last Name" class="in_reg" name="last_name" required>
            <input type="email" placeholder="Enter your email" class="in_reg" name="email" required>
            <?php if (isset($_GET['error'])): ?>
                <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <input type="password" placeholder="Enter your password" id="reg_pass" class="in_reg" name="password" required>
            <select id="country" name="country" class="in_reg" onchange="setPhoneCode()" required>
                <option value="">Select Country</option>
                <option value="INDIA">India</option>
                <option value="UNITED STATES">United States</option>
                <option value="UNITED KINGDOM">United Kingdom</option>
                <option value="CANADA">Canada</option>
                <option value="AUSTRALIA">Australia</option>
                <!-- Add more countries as needed -->
            </select>
            <div class="phone_input_wrapper">
                <input type="text" id="phone_code" class="in_reg phone_code" readonly value="+91"> <!-- Default for India -->
                <input type="text" placeholder="Phone number" class="in_reg phone_num" name="phone_number" required>
            </div>
            <button type="button" class="reg_btn" onclick="showBankDetails()">Next</button>
        </div>

        <div class="reg hidden" id="bank_details">
            <label class="reg_lbl">Bank Details</label>
            <select name="bank_name" class="in_reg" required id="bank_name">
                <option value="">Select Bank Name</option>
                <!-- Bank options will be populated based on the selected country -->
            </select>
            <input type="text" placeholder="Enter your bank account number" class="in_reg" name="bank_account_number" required>
            <input type="text" placeholder="Enter the balance in the account" name="credit_balance" class = "in_reg balance_input" required>
            <button type="button" class="reg_btn" onclick="showUserInfo()">Back</button>
            <button type="submit" class="reg_btn">Register</button>
        </div>
    </form>

    <script>
        function setPhoneCode() {
            var country = document.getElementById("country").value;
            var phoneCodeInput = document.getElementById("phone_code");

            if (country === "INDIA") {
                phoneCodeInput.value = "+91";
                populateBankOptions(['SBI', 'HDFC', 'ICICI', 'Axis', 'PNB']);
            } else if (country === "UNITED STATES") {
                phoneCodeInput.value = "+1";
                populateBankOptions(['Bank of America', 'Chase', 'Wells Fargo']);
            } else if (country === "UNITED KINGDOM") {
                phoneCodeInput.value = "+44";
                populateBankOptions(['HSBC', 'Barclays', 'Lloyds']);
            } else if (country === "CANADA") {
                phoneCodeInput.value = "+1";
                populateBankOptions(['Royal Bank of Canada', 'Toronto-Dominion Bank']);
            } else if (country === "AUSTRALIA") {
                phoneCodeInput.value = "+61";
                populateBankOptions(['Commonwealth Bank', 'Westpac', 'ANZ']);
            } else {
                phoneCodeInput.value = ""; // Default empty if no country selected
                clearBankOptions();
            }
        }

        function populateBankOptions(banks) {
            var bankSelect = document.getElementById("bank_name");
            bankSelect.innerHTML = '<option value="">Select Bank Name</option>'; // Clear existing options
            banks.forEach(function(bank) {
                var option = document.createElement("option");
                option.value = bank;
                option.textContent = bank;
                bankSelect.appendChild(option);
            });
        }

        function clearBankOptions() {
            var bankSelect = document.getElementById("bank_name");
            bankSelect.innerHTML = '<option value="">Select Bank Name</option>';
        }

        function showBankDetails() {
            document.getElementById("user_info").classList.add("hidden");
            document.getElementById("bank_details").classList.remove("hidden");
        }

        function showUserInfo() {
            document.getElementById("bank_details").classList.add("hidden");
            document.getElementById("user_info").classList.remove("hidden");
        }
    </script>
</body>
</html>
