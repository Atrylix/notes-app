<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    
    <link rel="stylesheet" href="<?= $styles ?>">
    <link rel="stylesheet" href="<?= $buttonStyles ?>">
    <link rel="stylesheet" href="<?= $inputStyles ?>">
    <link rel="stylesheet" href="<?= $normalize ?>">
    <link rel="stylesheet" href="<?= $navFooterStyles ?>">

    <link rel="stylesheet" href="<?= $settingsStyles ?>">
    
    <script src="<?= $noteHandler ?>"></script>
    <script src="<?= $redirectScript ?>"></script>
</head>
<body>
    <div class="content">
        <nav>
            <h1 class="Title">Notes</h1>
            <div class="nav-buttons">
                <button class="info-btn" onclick="redirect('/')">Home</button>
            </div>
        </nav>
        <div class="settings-container">
            <h1>Settings</h1>
            <div class="settings">
                <button style="margin-bottom: 15px; width: 16vw; padding: 10px" class="danger-btn fill" onclick="clearNotes()">Delete all notes</button>
                <button class="danger-btn fill" onclick="redirect('/logout')">Logout</button>
            </div>
        </div>
        <footer>
            <p class="copy">&copy; 2024 Developed and designed by Eli</p>
        </footer>
    </div>
</body>
</html>