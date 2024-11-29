<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Finance Tracker</title>
    <link rel="stylesheet" href="contact.css">
    <style>
        .success_msg { color: green; font-size: 30px; margin-top: 10px; margin-bottom: 10px; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <!-- Navbar Section -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="wallet.png" alt="Finance Tracker Logo">
                <h1>Finance Tracker</h1>
            </div>
            <ul class="nav-links">
                <li><a href="main_landing.html">Home</a></li>
                <li><a href="about_us.html">About Us</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
            </ul>
            <ul class="auth-links">
                <li><a href="login.php">Login</a></li>
                <li><a href="sign_up.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

   
    <!-- Contact Section -->
    <main>
        <section class="contact-section">
            <h2>Contact Us</h2>
            <form action="contact_us.php" method="post" class="contact-form">
                <input type="text" placeholder="Your Name" name="name" required>
                <input type="email" placeholder="Your Email" name="email" required>
                <textarea placeholder="Your Message" name="message" rows="5" required></textarea>
                <!-- Success Message -->
    <?php if(isset($_GET['success_msg'])): ?>
        <div class="success_msg" id="successMsg"><?php echo htmlspecialchars($_GET['success_msg']); ?></div>
    <?php endif; ?>
               
        <button type="submit">Send Message</button>
            </form>
        </section>
    </main>

    <!-- Footer Section -->
    <footer style="margin-top: 125px;">
        <p>&copy; 2024 Finance Tracker. All rights reserved.</p>
    </footer>


    <script>
    // Function to hide the success message after 10 seconds
    window.onload = function() {
        const successMsg = document.getElementById('successMsg');
        if (successMsg) {
            setTimeout(() => {
                successMsg.style.display = 'none'; // Hide the message

                // Update the URL to remove query string
                const newUrl = window.location.href.split('?')[0];
                window.history.pushState({ path: newUrl }, '', newUrl);
            }, 10000); // 10000 milliseconds = 10 seconds
        }
    }
</script>

</body>
</html>
