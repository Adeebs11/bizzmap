<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Bizz Map</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/stylelogin.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="fade-in">
  <div class="overlay"></div>
  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>

      <!-- Menampilkan pesan kesalahan -->
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf <!-- Tambahkan ini untuk melindungi form dari CSRF -->
        <div class="mb-3 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" required>
        </div>
        <div class="mb-3 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-login">Login</button>
        </div>
        <div class="text-center">
        </div>
    </form>
    
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
