// Toggle Password Visibility
const togglePassword = document.getElementById('togglePassword');
const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('password_confirmation');

if (togglePassword) {
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
}

if (toggleConfirmPassword) {
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
}

// Form Validation
const registerForm = document.getElementById('registerForm');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const termsCheckbox = document.getElementById('terms');
const message = document.getElementById('message');
const buttonText = document.getElementById('buttonText');
const loadingIcon = document.getElementById('loadingIcon');

function validateNameField(input) {
    if (input.value.trim().length < 3) {
        input.classList.add('border-red-500', 'shake');
        setTimeout(() => input.classList.remove('shake'), 500);
    } else {
        input.classList.remove('border-red-500');
    }
}

function validateEmailField(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(input.value)) {
        input.classList.add('border-red-500', 'shake');
        setTimeout(() => input.classList.remove('shake'), 500);
    } else {
        input.classList.remove('border-red-500');
    }
}

function validatePasswordField(input) {
    if (input.value.length < 8) {
        input.classList.add('border-red-500', 'shake');
        setTimeout(() => input.classList.remove('shake'), 500);
    } else {
        input.classList.remove('border-red-500');
    }
}

function validateConfirmPasswordField(input) {
    if (input.value !== passwordInput.value) {
        input.classList.add('border-red-500', 'shake');
        setTimeout(() => input.classList.remove('shake'), 500);
    } else {
        input.classList.remove('border-red-500');
    }
}

if (nameInput) {
    nameInput.addEventListener('blur', function() {
        validateNameField(this);
    });
}

if (emailInput) {
    emailInput.addEventListener('blur', function() {
        validateEmailField(this);
    });
}

if (passwordInput) {
    passwordInput.addEventListener('blur', function() {
        validatePasswordField(this);
    });
}

if (confirmPasswordInput) {
    confirmPasswordInput.addEventListener('blur', function() {
        validateConfirmPasswordField(this);
    });
}

if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        if (nameInput) nameInput.classList.remove('border-red-500');
        if (emailInput) emailInput.classList.remove('border-red-500');
        if (passwordInput) passwordInput.classList.remove('border-red-500');
        if (confirmPasswordInput) confirmPasswordInput.classList.remove('border-red-500');
        if (termsCheckbox) termsCheckbox.classList.remove('border-red-500');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let hasError = false;

        if (!nameInput || nameInput.value.trim().length < 3) {
            if (nameInput) {
                nameInput.classList.add('border-red-500', 'shake');
                setTimeout(() => nameInput.classList.remove('shake'), 500);
            }
            hasError = true;
        }

        if (!emailInput || !emailRegex.test(emailInput.value)) {
            if (emailInput) {
                emailInput.classList.add('border-red-500', 'shake');
                setTimeout(() => emailInput.classList.remove('shake'), 500);
            }
            hasError = true;
        }

        if (!passwordInput || passwordInput.value.length < 8) {
            if (passwordInput) {
                passwordInput.classList.add('border-red-500', 'shake');
                setTimeout(() => passwordInput.classList.remove('shake'), 500);
            }
            hasError = true;
        }

        if (!confirmPasswordInput || confirmPasswordInput.value !== passwordInput.value) {
            if (confirmPasswordInput) {
                confirmPasswordInput.classList.add('border-red-500', 'shake');
                setTimeout(() => confirmPasswordInput.classList.remove('shake'), 500);
            }
            hasError = true;
        }

        if (!termsCheckbox || !termsCheckbox.checked) {
            if (termsCheckbox) termsCheckbox.classList.add('border-red-500');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
}
