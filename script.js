document.addEventListener('DOMContentLoaded', function() {
            // DOM elements
            const signUpForm = document.getElementById('signUp');
            const signInForm = document.getElementById('signIn');
            const signUpButton = document.getElementById('signUpButton');
            const signInButton = document.getElementById('signInButton');
            const registerForm = document.getElementById('registerForm');
            const loginForm = document.getElementById('loginForm');
            const captchaPreview = document.getElementById('captchaPreview');
            const refreshCaptcha = document.getElementById('refreshCaptcha');
            const captchaInput = document.getElementById('captchaInput');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const passwordInput = document.getElementById('passwordSignUp');
            
            // Toggle password visibility
            const togglePasswordSignUp = document.getElementById('togglePasswordSignUp');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const togglePasswordLogin = document.getElementById('togglePasswordLogin');
            
            // Generate a random captcha
            let currentCaptcha = generateCaptcha();
            
            // Initialize captcha display
            captchaPreview.textContent = currentCaptcha;
            
            // Toggle between forms
            signUpButton.addEventListener('click', function() {
                signInForm.style.display = 'none';
                signUpForm.style.display = 'block';
                // Generate new captcha when switching to register form
                currentCaptcha = generateCaptcha();
                captchaPreview.textContent = currentCaptcha;
                captchaInput.value = '';
            });
            
            signInButton.addEventListener('click', function() {
                signUpForm.style.display = 'none';
                signInForm.style.display = 'block';
            });
            
            // Refresh captcha
            refreshCaptcha.addEventListener('click', function() {
                currentCaptcha = generateCaptcha();
                captchaPreview.textContent = currentCaptcha;
                captchaInput.value = '';
            });
            
            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const strength = calculatePasswordStrength(password);
                updateStrengthIndicator(strength);
            });
            
            // Password visibility toggles
            togglePasswordSignUp.addEventListener('click', function() {
                togglePasswordVisibility(passwordInput, togglePasswordSignUp);
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const confirmInput = document.getElementById('confirmPassword');
                togglePasswordVisibility(confirmInput, toggleConfirmPassword);
            });
            
            togglePasswordLogin.addEventListener('click', function() {
                const loginPassword = document.getElementById('passwordLogin');
                togglePasswordVisibility(loginPassword, togglePasswordLogin);
            });
            
            // Register form submission
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form values
                const firstName = document.getElementById('fName').value;
                const lastName = document.getElementById('lName').value;
                const email = document.getElementById('emailSignUp').value;
                const password = document.getElementById('passwordSignUp').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const enteredCaptcha = captchaInput.value;
                
                // Validation
                if (!validateEmail(email)) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                if (password.length < 6) {
                    alert('Password must be at least 6 characters long');
                    return;
                }
                
                if (password !== confirmPassword) {
                    alert('Passwords do not match');
                    return;
                }
                
                if (enteredCaptcha.toLowerCase() !== currentCaptcha.toLowerCase()) {
                    alert('Captcha verification failed');
                    // Generate new captcha
                    currentCaptcha = generateCaptcha();
                    captchaPreview.textContent = currentCaptcha;
                    captchaInput.value = '';
                    return;
                }

                // Get form values to store in database
                const formData = new FormData(registerForm);

                console.log('Form Data:', Object.fromEntries(formData.entries()));
                fetch('register.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === "success") {
                        signUpForm.style.display = 'none';
                        signInForm.style.display = 'block';
                        registerForm.reset();
                        strengthBar.style.width = '0%';
                        strengthText.textContent = '';
                    }
                })
                .catch(async (err) => {
                    // Try to get the raw response text for debugging
                    const raw = await err.response?.text?.();
                    alert('Registration failed. Server response: ' + (raw || err));
                });
            });


            // Login form submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(loginForm);

                fetch('login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === "success") {
                        window.location.href = "dashboard.php";
                    }
                })
                .catch(async (err) => {
                    const raw = await err.response?.text?.();
                    alert('Login failed. Server response: ' + (raw || err));
                });
            });
            
            // Generate random captcha function
            function generateCaptcha() {
                const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
                let captcha = '';
                for (let i = 0; i < 6; i++) {
                    captcha += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return captcha;
            }
            
            // Email validation function
            function validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
            
            // Calculate password strength
            function calculatePasswordStrength(password) {
                let strength = 0;
                
                // Length check
                if (password.length > 5) strength += 1;
                if (password.length > 7) strength += 1;
                if (password.length > 9) strength += 1;
                
                // Character variety
                if (/[A-Z]/.test(password)) strength += 1; // Uppercase letter
                if (/[a-z]/.test(password)) strength += 1; // Lowercase letter
                if (/[0-9]/.test(password)) strength += 1; // Number
                if (/[^A-Za-z0-9]/.test(password)) strength += 1; // Special character
                
                return Math.min(strength, 5); // Max strength is 5
            }
            
            // Update password strength indicator
            function updateStrengthIndicator(strength) {
                const colors = ['#ff6b6b', '#ff9e6b', '#ffd66b', '#a0e76b', '#4caf50'];
                const texts = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
                const width = strength * 20;
                
                strengthBar.style.width = `${width}%`;
                strengthBar.style.background = colors[strength - 1] || '#ff6b6b';
                strengthText.textContent = texts[strength - 1] || 'Very Weak';
                strengthText.style.color = colors[strength - 1] || '#ff6b6b';
            }
            
            // Toggle password visibility
            function togglePasswordVisibility(inputField, toggleButton) {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                
                // Toggle eye icon
                const eyeIcon = toggleButton.querySelector('i');
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            }
        });
