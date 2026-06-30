<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - Konfirmasi Password Anda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>     
          
        .gradient-bg {
            background: var(--color-primary);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }   
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-confirm {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-confirm::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-confirm:hover::before {
            left: 100%;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .password-strength {
            height: 4px;
            background-color: #e5e7eb;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { background-color: #ef4444; width: 33%; }
        .strength-medium { background-color: #f59e0b; width: 66%; }
        .strength-strong { background-color: #10b981; width: 100%; }
        
        .password-requirements {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 8px;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }
        
        .requirement i {
            margin-right: 8px;
            font-size: 0.75rem;
        }
        
        .requirement.valid i { color: #10b981; }
        .requirement.invalid i { color: #ef4444; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Confirm Password Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8 fade-in">            
            <h1 class="text-3xl font-bold text-white mb-2">Confirm Password</h1>
            <p class="text-white opacity-80">Change Your Password Here</p>
        </div>

        <!-- Confirm Password Form -->
        <div class="rounded-2xl bg-light shadow-2xl p-8 fade-in">
            <form method="POST" action="{{ route('password.confirm') }}" id="confirmPasswordForm" class="space-y-6">
                @csrf
                
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
                            placeholder="Enter your password"
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
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    
                    <!-- Password Requirements -->
                    <div class="password-requirements">
                        <div class="requirement invalid" id="lengthReq">
                            <i class="fas fa-times-circle"></i>
                            <span>Minimum 8 Characters</span>
                        </div>
                        <div class="requirement invalid" id="uppercaseReq">
                            <i class="fas fa-times-circle"></i>
                            <span>Minimum 1 Uppercase Letter</span>
                        </div>
                        <div class="requirement invalid" id="numberReq">
                            <i class="fas fa-times-circle"></i>
                            <span>Minimum 1 Number</span>
                        </div>
                    </div>
                    
                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @enderror
                </div>                

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="confirmButton"
                    class="w-full bg-secondary from-primary to-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-purple-700 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 btn-confirm shadow-lg"
                >
                    <span id="buttonText">Konfirmasi Password</span>
                    <i class="fas fa-spinner fa-spin ml-2 hidden" id="loadingIcon"></i>
                </button>

                <!-- Success/Error Message -->
                <div id="message" class="hidden p-4 rounded-lg text-center"></div>
                      
            </form>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-secondary hover:text-primary font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Login
                    </a>
                </p>
            </div>
        </div>
    </div>    

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
        
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Password Validation
        const strengthBar = document.getElementById('strengthBar');
        const lengthReq = document.getElementById('lengthReq');
        const uppercaseReq = document.getElementById('uppercaseReq');
        const numberReq = document.getElementById('numberReq');
        const passwordMatch = document.getElementById('passwordMatch');
        const passwordMismatch = document.getElementById('passwordMismatch');

        function validatePassword() {
            const password = passwordInput.value;
            let strength = 0;
            
            // Check length
            if (password.length >= 8) {
                lengthReq.classList.remove('invalid');
                lengthReq.classList.add('valid');
                strength++;
            } else {
                lengthReq.classList.remove('valid');
                lengthReq.classList.add('invalid');
            }
            
            // Check uppercase
            if (/[A-Z]/.test(password)) {
                uppercaseReq.classList.remove('invalid');
                uppercaseReq.classList.add('valid');
                strength++;
            } else {
                uppercaseReq.classList.remove('valid');
                uppercaseReq.classList.add('invalid');
            }
            
            // Check number
            if (/[0-9]/.test(password)) {
                numberReq.classList.remove('invalid');
                numberReq.classList.add('valid');
                strength++;
            } else {
                numberReq.classList.remove('valid');
                numberReq.classList.add('invalid');
            }
            
            // Update strength bar
            strengthBar.className = 'password-strength-bar';
            if (strength === 1) {
                strengthBar.classList.add('strength-weak');
            } else if (strength === 2) {
                strengthBar.classList.add('strength-medium');
            } else if (strength === 3) {
                strengthBar.classList.add('strength-strong');
            }
        }

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    passwordMatch.classList.remove('hidden');
                    passwordMismatch.classList.add('hidden');
                } else {
                    passwordMatch.classList.add('hidden');
                    passwordMismatch.classList.remove('hidden');
                }
            } else {
                passwordMatch.classList.add('hidden');
                passwordMismatch.classList.add('hidden');
            }
        }

        passwordInput.addEventListener('input', function() {
            validatePassword();
            checkPasswordMatch();
        });

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Form Submission
        const confirmPasswordForm = document.getElementById('confirmPasswordForm');
        const confirmButton = document.getElementById('confirmButton');
        const buttonText = document.getElementById('buttonText');
        const loadingIcon = document.getElementById('loadingIcon');
        const message = document.getElementById('message');

        confirmPasswordForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Validate password strength
            validatePassword();
            if (passwordInput.value.length < 8 || !/[A-Z]/.test(passwordInput.value) || !/[0-9]/.test(passwordInput.value)) {
                message.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                message.classList.add('bg-red-100', 'text-red-700');
                message.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Password tidak memenuhi persyaratan keamanan';
                passwordInput.classList.add('border-red-500', 'shake');
                setTimeout(() => passwordInput.classList.remove('shake'), 500);
                return;
            }
            
            // Check password match
            if (passwordInput.value !== confirmPasswordInput.value) {
                message.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                message.classList.add('bg-red-100', 'text-red-700');
                message.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Password tidak cocok';
                confirmPasswordInput.classList.add('border-red-500', 'shake');
                setTimeout(() => confirmPasswordInput.classList.remove('shake'), 500);
                return;
            }
            
            // Show loading state
            confirmButton.disabled = true;
            buttonText.textContent = 'Memproses...';
            loadingIcon.classList.remove('hidden');
            
            // Simulate API call
            setTimeout(() => {
                // Hide loading state
                confirmButton.disabled = false;
                buttonText.textContent = 'Konfirmasi Password';
                loadingIcon.classList.add('hidden');
                
                // Show success message
                message.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                message.classList.add('bg-green-100', 'text-green-700');
                message.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Password berhasil dikonfirmasi! Mengalihkan...';
                
                // Simulate redirect
                setTimeout(() => {
                    // window.location.href = '/dashboard';
                    console.log('Redirecting to dashboard...');
                }, 2000);
            }, 2000);
        });
    </script>
</body>
</html>