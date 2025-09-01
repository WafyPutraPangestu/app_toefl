<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Akun Anda Telah Diaktifkan</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Kabar baik! Akun Anda di <strong>{{ config('app.name') }}</strong> telah berhasil kami tinjau dan disetujui oleh
        admin.</p>
    <p>Sekarang Anda dapat masuk ke aplikasi kapan saja menggunakan akun Google Anda.</p>

    <p style="margin-top: 20px;">
        <a href="{{ url('/login') }}"
            style="display: inline-block; padding: 12px 24px; font-size: 16px; color: #ffffff; background-color: #28a745; text-decoration: none; border-radius: 5px;">
            Login Sekarang
        </a>
    </p>

    <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
    <p>Terima kasih,<br>Tim Aplikasi TOEFL Anda</p>
</body>

</html>
