<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Register</title>
    <link rel="stylesheet" href="assets/css/auth-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>

<body>
    <div id="background">
        <div id="panel-box">
            <div class="panel">
                <div class="auth-form on" id="login">
                    <div id="form-title">Log In</div>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input name="email" type="text" required="required" placeholder="Email" />
                        <input name="password" type="password" required="required" placeholder="Password" />
                        <button type="Submit" name="login">Log In</button>
                    </form>
                </div>

                <div class="auth-form" id="signup">
                    <div id="form-title">Register</div>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input name="email" type="text" required="required" placeholder="Email" />
                        <input name="password" type="password" required="required" placeholder="Password" />
                        <button type="Submit" name="signup">Sign Up</button>
                    </form>
                </div>

            </div>
            <div class="panel">
                <div id="switch">Sign Up</div>
                <div id="image-overlay"></div>
                <div id="image-side"></div>
            </div>
        </div>
    </div>
    <!-- partial -->
    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
    <script src="assets/js/auth-event.js"></script>

</body>

</html>