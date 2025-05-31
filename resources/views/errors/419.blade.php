<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="3;url={{ url('/') }}">
    <title>Halaman Expired</title>
</head>
<body>
    <h1>Session Expired</h1>
    <p>Kamu akan diarahkan ke halaman utama</p>

    <script>
        setTimeout(() => {
            window.location.href = "{{ url('/') }}"; // Ganti jika landing page kamu bukan root
        }, 1000);
    </script>
</body>
</html>
