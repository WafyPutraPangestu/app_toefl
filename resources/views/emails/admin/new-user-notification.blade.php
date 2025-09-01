<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pendaftar Baru</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Halo Admin,</h2>
    <p>Ada pengguna baru yang telah mendaftar melalui Google dan saat ini sedang menunggu persetujuan Anda.</p>

    <h3>Detail Pengguna:</h3>
    <ul>
        <li><strong>Nama:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Waktu Daftar:</strong> {{ $user->created_at->format('d F Y, H:i') }} WIB</li>
    </ul>

    <p>Silakan masuk ke panel admin aplikasi Anda untuk meninjau dan menyetujui pendaftaran ini.</p>

    <p>Terima kasih,<br>Sistem Aplikasi TOEFL Anda</p>
</body>

</html>
