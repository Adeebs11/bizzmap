<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bizz Map</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/stylelanding.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="fade-in">
  <div class="overlay"></div>
  <div class="content">
    <h1>Selamat Datang di BizzMap</h1>
    <p>Platform interaktif untuk menjelajahi peta, demografi, dan analitik pelanggan & non pelanggan.</p>
    <button class="btn-login" onclick="redirectToLogin()">Get Started</button>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function redirectToLogin() {
      window.location.href = '{{ url("/login") }}';
    }
  </script>
</body>
</html>
