@extends('layouts.app')

@section('content')
<style>
    /* Styling untuk form login, tidak mengubah body */
    :root {
        --primary-color: #2c7c3d;
        --secondary-color: #f5a623;
    }

    body {
        /*
        * Menghilangkan gaya body di sini karena sudah ditangani oleh layouts.app.
        * Latar belakang diatur di main, bukan di body.
        */
        background-color: var(--light-bg);
    }
    
    main {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1a3e23 100%);
        flex: 1; /* Memastikan main mengisi sisa ruang */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box; /* Memastikan padding tidak membuat main menjadi lebih besar */
        width: 100vw; /* Memastikan main mengambil lebar penuh viewport */
        height: 100vh; /* Memastikan main mengambil tinggi penuh viewport */
    }

    .login-wrapper {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        padding: 40px;
        max-width: 700px; /* Ukuran dilebarkan */
        width: 100%;
        text-align: center;
        transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        position: relative;
        overflow: hidden;
        color: #fff;
    }

    .login-wrapper:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }
    
    .login-header {
        margin-bottom: 2rem;
    }
    
    .login-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        color: #fff;
    }

    .login-header p {
        opacity: 0.8;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }
    
    .form-floating input {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        color: #fff;
        padding: 1rem 1.5rem;
        height: auto;
        transition: all 0.3s ease;
    }
    
    .form-floating input:focus {
        background: rgba(255, 255, 255, 0.3);
        border-color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.2);
    }
    
    .form-floating label {
        color: rgba(255, 255, 255, 0.6);
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
    }

    .form-floating input:not(:placeholder-shown) ~ label,
    .form-floating input:focus ~ label {
        opacity: 0.8;
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }
    
    .form-floating .form-control:not(:placeholder-shown) {
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
    }

    .password-field {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        z-index: 10;
        padding: 5px;
        transition: color 0.3s ease;
    }
    
    .password-toggle:hover {
        color: #fff;
    }
    
    .login-btn {
        width: 100%;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        background: #fff;
        color: var(--primary-color);
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }
    
    .login-btn:hover {
        background: var(--secondary-color);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .login-btn:active {
        transform: translateY(0);
    }
    
    .forgot-password a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .forgot-password a:hover {
        color: #fff;
        text-decoration: underline;
    }
    
    .register-link {
        margin-top: 2rem;
    }
    
    .register-link a {
        color: var(--secondary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .register-link a:hover {
        color: #fff;
    }

    .alert {
        border-radius: 10px;
        text-align: left;
        border-left: 5px solid;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger, .error-message {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        border-left: 5px solid #dc3545;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: left;
    }
    
    @media (max-width: 768px) {
        .login-wrapper {
            padding: 30px;
            max-width: 90%;
        }
        
        .login-header h2 {
            font-size: 2rem;
        }
    }
</style>

<div class="row justify-content-center w-100">
    <div class="col-md-6 col-lg-5">
        <div class="login-wrapper">
            <div class="login-header">
                <h2>Selamat Datang!</h2>
                <p>Silakan masuk ke akun Anda</p>
            </div>

            <div class="login-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="error-message">
                        <strong>Oops!</strong> Terdapat beberapa masalah dengan data Anda.<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating">
                        <input 
                            id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            placeholder="Alamat Email"
                        >
                        <label for="email">Alamat Email</label>
                    </div>

                    <div class="form-floating password-field">
                        <input 
                            id="password" 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Kata Sandi"
                        >
                        <label for="password">Kata Sandi</label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check text-white">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <button type="submit" class="login-btn">
                        Masuk
                    </button>
                </form>

                @if (Route::has('register'))
                    <div class="register-link">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'fas fa-eye';
    }
}
</script>
@endsection