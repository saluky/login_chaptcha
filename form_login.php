<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login with CAPTCHA</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <form action="login_process.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
