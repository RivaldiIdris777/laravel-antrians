// Toggle Password Visibility
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (togglePassword) {
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class=\'fas fa-eye\'></i>' : '<i class=\'fas fa-eye-slash\'></i>';
    });
}

// Form Validation
const loginForm = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const passwordField = document.getElementById('password');
const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');

function validateEmailField(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(input.value)) {
        if (emailError) emailError.classList.remove('hidden');
        input.classList.add('border-red-500');
    } else {
        if (emailError) emailError.classList.add('hidden');
        input.classList.remove('border-red-500');
    }
}

function validatePasswordField(input) {
    if (input.value.length < 8) {
        if (passwordError) passwordError.classList.remove('hidden');
        input.classList.add('border-red-500');
    } else {
        if (passwordError) passwordError.classList.add('hidden');
        input.classList.remove('border-red-500');
    }
}

if (emailInput) {
    emailInput.addEventListener('blur', function() {
        validateEmailField(this);
    });
}

if (passwordField) {
    passwordField.addEventListener('blur', function() {
        validatePasswordField(this);
    });
}

if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (emailError) emailError.classList.add('hidden');
        if (passwordError) passwordError.classList.add('hidden');
        if (emailInput) emailInput.classList.remove('border-red-500');
        if (passwordField) passwordField.classList.remove('border-red-500');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput || !emailRegex.test(emailInput.value)) {
            if (emailError) emailError.classList.remove('hidden');
            if (emailInput) {
                emailInput.classList.add('border-red-500', 'shake');
                setTimeout(() => emailInput.classList.remove('shake'), 500);
            }
            return;
        }

        if (!passwordField || passwordField.value.length < 8) {
            if (passwordError) passwordError.classList.remove('hidden');
            if (passwordField) {
                passwordField.classList.add('border-red-500', 'shake');
                setTimeout(() => passwordField.classList.remove('shake'), 500);
            }
            return;
        }

        const rememberMe = document.getElementById('rememberMe');
        if (rememberMe && emailInput) {
            if (rememberMe.checked) {
                localStorage.setItem('rememberEmail', emailInput.value);
            } else {
                localStorage.removeItem('rememberEmail');
            }
        }

        loginForm.submit();
    });
}

window.addEventListener('load', function() {
    const rememberedEmail = localStorage.getItem('rememberEmail');
    const rememberMe = document.getElementById('rememberMe');
    if (rememberedEmail && emailInput) {
        emailInput.value = rememberedEmail;
        if (rememberMe) rememberMe.checked = true;
    }
});
