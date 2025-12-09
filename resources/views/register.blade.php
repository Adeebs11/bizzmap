<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bizz Map</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleregister.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="overlay"></div>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Nama" required>
            </div>
            <div class="input-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="agreement" required> I agree to the terms and conditions
                </label>
            </div>
            <button type="submit" class="btn-register">Register</button>
            <div class="text-center">
                <a href="login">Sudah punya akun? Login disini</a>
            </div>
        </form>
    </div>
    
