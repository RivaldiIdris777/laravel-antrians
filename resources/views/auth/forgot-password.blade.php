<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Reset Your Password</title>
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
        
        .btn-reset {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-reset::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-reset:hover::before {
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
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Forgot Password Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8 fade-in">            
            <h1 class="text-3xl font-bold text-white mb-2">Forgot Password?</h1>
            <p class="text-white/80">Insert your email to reset your password</p>
        </div>

        <!-- Forgot Password Form -->
        <div class="rounded-2xl bg-light shadow-2xl p-8 fade-in">
            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" class="space-y-6">
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
                        <span class="text-red-500 text-sm mt-1 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="resetButton"
                    class="w-full bg-secondary from-primary to-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-purple-700 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 btn-reset shadow-lg"
                >
                    <span id="buttonText">Send Password Reset Link</span>
                    <i class="fas fa-spinner fa-spin ml-2 hidden" id="loadingIcon"></i>
                </button>

                <!-- Success/Error Message -->
                <div id="message" class="hidden p-4 rounded-lg text-center"></div>
                      
            </form>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Remember Password?
                    <a href="{{ route('login') }}" class="text-secondary hover:text-primary font-semibold transition-colors">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center text-white/70 text-sm">
            <p>
                <i class="fas fa-info-circle mr-1"></i>
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.

            </p>
        </div>
    </div>    

    <script>
        // Form Validation
        const forgotPasswordForm = document.getElementById('forgotPasswordForm');
        const emailInput = document.getElementById('email');
        const message = document.getElementById('message');
        const resetButton = document.getElementById('resetButton');
        const buttonText = document.getElementById('buttonText');
        const loadingIcon = document.getElementById('loadingIcon');

        // Email validation
        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.value)) {
                showError('Format email tidak valid');
                this.classList.add('border-red-500', 'shake');
                setTimeout(() => this.classList.remove('shake'), 500);
            } else {
                hideError();
                this.classList.remove('border-red-500');
            }
        });

        // Form Submission
        forgotPasswordForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Reset errors
            hideError();
            emailInput.classList.remove('border-red-500');
            
            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                showError('Format email tidak valid');
                emailInput.classList.add('border-red-500', 'shake');
                setTimeout(() => emailInput.classList.remove('shake'), 500);
                return;
            }
            
            // Show loading state
            resetButton.disabled = true;
            buttonText.textContent = 'Mengirim...';
            loadingIcon.classList.remove('hidden');
            
            // Simulate API call
            setTimeout(() => {
                // Hide loading state
                resetButton.disabled = false;
                buttonText.textContent = 'Kirim Link Reset Password';
                loadingIcon.classList.add('hidden');
                
                // Show success message
                message.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                message.classList.add('bg-green-100', 'text-green-700');
                message.innerHTML = `
                    <i class="fas fa-check-circle mr-2"></i>
                    Password reset link has been sent to your email!
                `;
                
                // Clear form after success
                setTimeout(() => {
                    emailInput.value = '';
                    hideError();
                }, 3000);
            }, 2000);
        });

        // Helper functions
        function showError(text) {
            message.classList.remove('hidden', 'bg-green-100', 'text-green-700');
            message.classList.add('bg-red-100', 'text-red-700');
            message.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${text}`;
        }

        function hideError() {
            message.classList.add('hidden');
        }

        // Auto-hide message after 5 seconds
        setInterval(() => {
            if (!message.classList.contains('hidden')) {
                message.style.opacity = '0';
                setTimeout(() => {
                    message.classList.add('hidden');
                    message.style.opacity = '1';
                }, 500);
            }
        }, 5000);
    </script>
</body>
</html>