<?php
session_start();
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']); // Clear error after displaying
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/1eb1993361.js" crossorigin="anonymous"></script>
    <script src="validate.js" defer></script>
    <title>Login</title>

</head>
<div id="toast" class="toast">You need to log in to continue</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let showToast = <?php echo $showToast ? 'true' : 'false'; ?>;
    
    if (showToast) {
        let toast = document.getElementById("toast");
        toast.classList.add("show");

        setTimeout(function() {
            toast.classList.remove("show");
        }, 2000);
    }
});
</script>
<body>
    <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0" mask-type="alpha">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
      0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
      591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
      167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />
        </mask>

        <g mask="url(#mask0)">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
      0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
      591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
      167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />

            <!-- Insert your image (recommended size: 1000 x 1200) -->
            <image class="login__img" href="logo/loginbg3.jpg" />
        </g>
    </svg>

    <div class="login container grid" id="loginAccessRegister">
        <div class="login__access">
            <h1 class="login__title">LogIn to your account</h1>
            <div class="login__area">
                <form action="functions/authcode.php" class="login__form>" method="post">
                    <div class="login__content grid">
                        <div class="login__box">
                            <input type="text" id="username" name="username" required placeholder="" class="login__input">
                            <label for="username" class="login__label">Username</label>
                            <i class="ri-mail-fill login__icon"></i>
                        </div>
                        <div class="login__box">
                            <input type="password" id="password" name="password" required placeholder="" class="login__input">
                            <label for="password" class="login__label">Password</label>
                            <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                        </div>
                    </div>

                    

                    <button type="submit" name="login_btn" class="login__button">Login</button>
                </form>


                <p class="login__switch">
                    Don't have an account?
                    <button id="loginButtonRegister">Create Account</button>
                    <br><br>
                    <a href="index.php">Back to Home Page</a>
                </p>
            </div>
        </div>

        <div class="login__register">
            <h1 class="login__title">Create new account</h1>

            <div class="login__area">
                <form action="functions/authcode.php" class="login__form" method="post">
                    <div class="login__content gird">
                        <div class="login__group grid">
                            <div class="login__box">
                                <input type="text" id="usernames" name="username" required placeholder="" class="login__input">
                                <label for="names" class="login__label">Usernames</label>

                                <i class="ri-id-card-fill login__icon"></i>
                            </div>
                            <div class="login__box">
                                <input type="email" id="emailCreate" name="email" required placeholder="" class="login__input">
                                <label for="emailCreate" class="login__label">Email</label>

                                <i class="ri-mail-fill login__icon"></i>
                            </div>
                            <div class="login__box_password">
                                <input type="password" id="passwordCreate" name="password" required placeholder="" class="login__input_password">
                                <label for="passwordCreate" class="login__label">Password</label>

                                <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordCreate"></i>
                            
                            </div>
                            <div class="content">
                                <p>Password must contains</p>
                                <ul class="requirement-list">
                                    <li>
                                        <i class="fa-solid fa-circle"></i>
                                        <span>At least 8 characters length</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle"></i>
                                        <span>At least 1 number (0...9)</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle"></i>
                                        <span>At least 1 lowercase letter (a...z)</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle"></i>
                                        <span>At least 1 special symbol (!...$)</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle"></i>
                                        <span>At least 1 uppercase letter (A...Z)</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="login__box_confirm">
                                <input type="password" id="passwordCreate" name="cnpassword" required placeholder="" class="login__input">
                                <label for="passwordCreate" class="login__label" name="register_btn">Confirm Password</label>
                            </div>
                        </div>

                    </div>
                    <button type="submit" name="register_btn" class="login__button">Create Account</button>

                    
                </form>

                <p class="login__switch">
                    Already have an account?
                    <button id="loginButtonAccess">LogIn</button>
                </p>
            </div>
        </div>

    </div>

    <script src="login.js"></script>
    <div id="toast" class="toast"><?php echo $error_message; ?></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let toastMessage = "<?php echo $error_message; ?>";
    if (toastMessage.trim() !== "") {
        let toast = document.getElementById("toast");
        toast.innerText = toastMessage;
        toast.classList.add("show");

        setTimeout(function () {
            toast.classList.remove("show");
        }, 3000);
    }
});
</script>
</body>

</html>