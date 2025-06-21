<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Registration & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- Register Form -->
    <div class="container" id="signUp" style="display: none;">
        <h1 class="form-title">Create Account</h1>
        <form id="registerForm" action="register.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="fName" name="fName" placeholder=" " required>
                <label for="fName">First Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="lName" name="lName" placeholder=" " required>
                <label for="lName">Last Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="emailSignUp" name="email" placeholder=" " required>
                <label for="emailSignUp">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="passwordSignUp" name="password" placeholder=" " required>
                <label for="passwordSignUp">Password</label>
                <span class="password-toggle" id="togglePasswordSignUp">
                    <i class="fas fa-eye"></i>
                </span>
                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
                <div class="strength-text" id="strengthText"></div>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder=" " required>
                <label for="confirmPassword">Confirm Password</label>
                <span class="password-toggle" id="toggleConfirmPassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <div class="captcha-group">
                <label for="captchaInput" class="captcha-label">Enter Captcha</label>
                <div class="captcha-box">
                    <span id="captchaPreview"></span>
                    <button type="button" id="refreshCaptcha" class="refresh-captcha" title="Refresh Captcha">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
                <input type="text" id="captchaInput" placeholder="Enter captcha text" required>
            </div>

            <input type="submit" class="btn" value="Sign Up">
        </form>
        <p class="or">----------- Or -----------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Already have an account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <!-- Login Form -->
    <div class="container" id="signIn">
        <h1 class="form-title">Welcome Back</h1>
        <form id="loginForm" action="register.php" method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="emailLogin" name="email" placeholder=" " required>
                <label for="emailLogin">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="passwordLogin" name="password" placeholder=" " required>
                <label for="passwordLogin">Password</label>
                <span class="password-toggle" id="togglePasswordLogin">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <p class="recover"><a href="#">Recover Password</a></p>
            <input type="submit" class="btn" value="Sign In">
        </form>
        <p class="or">----------- Or -----------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>
