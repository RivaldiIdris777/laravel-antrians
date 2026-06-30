<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Selamat Datang Kembali</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-primary min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8 fade-in">            
            <h1 class="text-3xl font-bold text-white mb-2">Masuk ke Akun Anda</h1>            
        </div>

        <!-- Login Form -->
        <div class="rounded-2xl bg-light shadow-2xl p-8 fade-in">
            <form  method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                @csrf
                
                <!-- Email Input -->
                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-secondary"></i>Email
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-3 pl-12 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent input-focus"
                            placeholder="name@email.com"
                        >
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('email')
                        <span id="emailError" class="text-red-500 text-sm mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @else
                        <span id="emailError" class="hidden text-red-500 text-sm mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>Email tidak valid.
                        </span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-secondary"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            required
                            class="w-full px-4 py-3 pl-12 pr-12 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent input-focus"
                            placeholder="••••••••"
                        >
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button 
                            type="button" 
                            id="togglePassword"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span id="passwordError" class="text-red-500 text-sm mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @else
                        <span id="passwordError" class="hidden text-red-500 text-sm mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>Password harus minimal 8 karakter.
                        </span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">                    
                    <a href="{{ route('password.request') }}" id="forgotPasswordLink" class="text-sm text-secondary hover:text-primary transition-colors">
                        Lupa Password?
                    </a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    
                    class="w-full bg-secondary from-primary to-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-purple-700 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 btn-login shadow-lg"
                >
                    <span id="buttonText">Sign In</span>                    
                </button>

                <!-- Success/Error Message -->
                <div id="message" class="hidden p-4 rounded-lg text-center"></div>
                      
            </form>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum Punya Akun?
                    <a href="{{ route('register') }}" class="text-secondary hover:text-primary font-semibold transition-colors">
                    Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>    

    <script src="{{ asset('js/loginpage.js') }}"></script>
</body>
</html>