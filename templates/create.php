<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>

    <link rel="stylesheet" href="<?= $styles ?>">
    <link rel="stylesheet" href="<?= $buttonStyles ?>">
    <link rel="stylesheet" href="<?= $inputStyles ?>">
    <link rel="stylesheet" href="<?= $normalize ?>">
    <link rel="stylesheet" href="<?= $navFooterStyles ?>">

    <link rel="stylesheet" href="<?= $createStyles ?>">
    
    <script src="<?= $noteHandler ?>"></script>
    <script src="<?= $redirectScript ?>"></script>
</head>
<body>
    <div class="content">
        <nav>
            <h1 class="Title">Notes</h1>
            <div class="nav-buttons">
                <button id="save-btn" class="success-btn" onclick="savenote()">Save</button>
                <button class="danger-btn" onclick="if (confirm('are you sure you want to exit? You will lose all unsaved progress.')) {redirect('/')}">Back</button>
            </div>
        </nav>
        <div class="textarea-container">
            <input class="title" id="title" placeholder="Title"></input>
            <textarea class="content" id="content" placeholder="Note..."></textarea>
        </div>
        <footer>
            <p class="copy">&copy; 2024 Developed and designed by Eli</p>
        </footer>
    </div>
    <script>
        const url = new URL(window.location.href);
        const params = url.searchParams;

        const title = params.get('title');
        const content = params.get('content');
        const id = params.get('id');

        if (title != null && content != null && id != null) {
            document.getElementById('title').setAttribute('value', title);
            document.getElementById('content').innerHTML = content;

            document.getElementById('save-btn').innerHTML = 'Modify';
            document.getElementById('save-btn').setAttribute('onclick', `modifyNote(${id})`);
        }
    </script>
</body>
</html>