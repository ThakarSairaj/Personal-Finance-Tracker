<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <script src="login.js"></script>
    <title>Document</title>
</head>
<body>


    <!--Login Form-->
    
    <form action="user_login.php" method="post" name="login_form">
        <label for=""> </label>

        <div class="log">
            <label class="log_lbl" >Login</label>
            <input type="text" placeholder="Enter your email" class="in_log" name="login_email">

            <input type="password" placeholder="Enter your password" id="pass" name="login_password">
            <label class="check_lbl">

               <input type="checkbox"  class="check_box" onclick="showPass()">
               Show Password</label>
               <button class="log_btn">Login</button>
        </div>
    </form>


    <!--Registeration Form-->

    <form action="p.php" method="post" name="registeration_form" ></form>
    
</body>
</html>