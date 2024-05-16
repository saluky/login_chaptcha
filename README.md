Membuat form login dengan CAPTCHA menggunakan PHP memerlukan beberapa langkah. Anda dapat menggunakan reCAPTCHA dari Google, yang menyediakan API untuk memverifikasi CAPTCHA. Berikut adalah langkah-langkah untuk membuat form login dengan reCAPTCHA:

1. **Daftarkan Situs Anda di Google reCAPTCHA**:
   - Kunjungi [Google reCAPTCHA](https://www.google.com/recaptcha/intro/v3.html).
   - Daftarkan situs Anda untuk mendapatkan `Site Key` dan `Secret Key`.

2. **Buat File Konfigurasi**:
   - Buat file `config.php` untuk menyimpan konfigurasi reCAPTCHA.

   ```php
   <?php
   // reCAPTCHA keys
   $siteKey = 'YOUR_SITE_KEY';
   $secretKey = 'YOUR_SECRET_KEY';
   ?>
   ```

3. **Buat Form Login dengan CAPTCHA**:
   - Buat file `login.php` untuk menampilkan form login.

   ```php
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
   ```

4. **Proses Form Login dan Verifikasi CAPTCHA**:
   - Buat file `login_process.php` untuk memproses login dan verifikasi CAPTCHA.

   ```php
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
   ```

5. **Uji Aplikasi Anda**:
   - Jalankan server lokal Anda (misalnya, menggunakan `php -S localhost:8000` jika Anda menggunakan server built-in PHP).
   - Akses `http://localhost:8000/login.php` di browser Anda.
   - Masukkan username dan password, lalu selesaikan CAPTCHA.
   - Klik "Login" dan verifikasi apakah login berhasil atau tidak.

Dengan langkah-langkah ini, Anda akan memiliki form login dengan CAPTCHA menggunakan PHP. Pastikan untuk mengganti `YOUR_SITE_KEY` dan `YOUR_SECRET_KEY` dengan kunci yang Anda dapatkan dari Google reCAPTCHA.
