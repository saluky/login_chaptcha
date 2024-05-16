<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verifikasi reCAPTCHA
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        ]
    ];

    $context = stream_context_create($options);
    $recaptchaVerify = file_get_contents($recaptchaUrl, false, $context);
    $recaptchaSuccess = json_decode($recaptchaVerify);

    if ($recaptchaSuccess->success) {
        // Proses login, misalnya memeriksa kredensial pengguna di database
        // Contoh sederhana (tidak aman untuk produksi):
        $validUsername = 'user';
        $validPassword = 'pass';

        if ($username === $validUsername && $password === $validPassword) {
            echo 'Login successful!';
            // Set sesi pengguna dan redirect ke halaman beranda atau dashboard
        } else {
            echo 'Invalid username or password!';
        }
    } else {
        echo 'CAPTCHA verification failed!';
    }
} else {
    echo 'Invalid request method!';
}
?>
