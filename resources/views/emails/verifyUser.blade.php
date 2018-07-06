<!DOCTYPE html>
<html>
<head>
    <title>Selamat Bergabung di Yourganic</title>
</head>
<body>
    <h2>Selamat datang {{$user['name']}} di aplikasi Yourganic</h2>
    <br/>
    Kamu telah mendaftarkan diri sebagai {{$user['name']}} menggunakan {{$user['email']}} , Silahkan klik tautan berikut untuk memverifikasi akun anda.
    <br/>
    <a href="{{url('user/verify', $user->verifyUser->token)}}"><button>Verify Email</button></a>
    <br>
    Terima kasih.
</body>
</html>
