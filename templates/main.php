<?php
    if (isset($_SESSION['notes'])) {
        $notes = $_SESSION['notes'];
    } else {
        echo "No notes found in session.";
    }
?>

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
    
    <link rel="stylesheet" href="<?= $noteStyles ?>">
    
    <script src="<?= $noteHandler ?>"></script>
    <script src="<?= $redirectScript ?>"></script>
</head>
<body>
    <div class="content">
        <nav>
            <h1 class="Title">Notes</h1>
            <div class="nav-buttons">
                <button class="success-btn" onclick="redirect('/')">Refresh</button>
                <button class="caution-btn" onclick="redirect('/create')">Create</button>
                <button class="info-btn" onclick="redirect('/settings')">Settings</button>
            </div>
        </nav>
        <div class="notes-area">
            <div id="notes-container" class="notes-container">
                <?php
                    for ($i = 0; $i < count($notes); $i++) {
                        echo '<div class="note-card">';
                        echo "<h2>{$notes[$i]['title']}</h2>";
                        echo "<p>{$notes[$i]['note']}</p>";
                        echo '<div class="note-options">';
                        echo "<button onclick=\"viewNote('{$notes[$i]['title']}', '{$notes[$i]['note']}', {$notes[$i]['id']})\" class=\"success-btn fill\">View</button>";
                        echo "<button onclick=\"deleteNote({$notes[$i]['id']})\" class=\"danger-btn fill\">Delete</button>";
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <footer>
            <p class="copy">&copy; 2024 Developed and designed by Eli</p>
        </footer>
    </div>
</body>
</html>