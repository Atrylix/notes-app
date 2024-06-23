<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
        
    <link rel="stylesheet" href="<?= $styles ?>">
    <link rel="stylesheet" href="<?= $buttonStyles ?>">
    <link rel="stylesheet" href="<?= $inputStyles ?>">
    <link rel="stylesheet" href="<?= $normalize ?>">
    <link rel="stylesheet" href="<?= $navFooterStyles ?>">

    <link rel="stylesheet" href="<?= $formStyles ?>">
    <script src="<?= $loginFormError ?>"></script>
    <script src="<?= $redirectScript ?>"></script>
</head>
<body>
    <div class="content">
        <nav>
            <h1 class="Title">Notes</h1>
            <button class="info-btn" onclick="redirect('/signup')">Sign Up</button>
        </nav>
        <div class="login-div">
            <div id="error-message" class="error-message"></div>
            <h1 class="title">Login</h1>
            <form action="<?= $site_path ?>/proccess-login" method="post" class="form">
                <input type="text" id="username" name="username" placeholder="Username">
                <input type="password" id="password" name="password" placeholder="Password">
                <div class="options">
                    <p><input type="checkbox" name="remember" id="remember"> Remember me</p>
                </div>
                <button class="success-btn" type="submit">Login</button>
            </form>
        </div>
        <footer>
            <p class="copy">&copy; 2024 Developed and designed by Eli</p>
        </footer>
    </div>
</body>
</html>