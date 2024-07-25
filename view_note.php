<?php
// Inclure les fichiers nécessaires
require 'conf.php';
require 'app/fcts-tools.php';
require 'app/fcts-html.php';
require 'app/fcts-app.php';

// récuperer toutes les notes 
$notes = GETListAllNotes();

// Récupérer l'identifiant de la note depuis l'URL
$filename = ( $_GET['file'] ?? '');

// Charger les détails de la note
$note = LOADNoteFromFile($filename);

// Vérifier si la note existe
if (!$note) {
    // Note non trouvée, rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($note['title']); ?> - <?php echo APP_TITLE; ?></title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>

<header>
        <img src="./img/Duckspace.png" alt="image">
    </header>

    <?php echo HTMLInsertMenu(); ?>
    <hr>
    <div class="container-view-note">
        <div>
            <h1><?php echo htmlspecialchars($note['title']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
            <p>Type: <?php echo htmlspecialchars($note['type']); ?></p>
            <p>Date: <?php echo htmlspecialchars($note['date']); ?></p>
        </div>
        <div>
            <!--boutons pour diriger vers une autre page pour editer ou supprimer la note -->
            <a href="edit_note.php?id=<?php echo urlencode($filename); ?>">Modifier</a>
            <!-- Lien pour supprimer la note -->
            <a href="delete_note.php?file=<?php echo urlencode($filename); ?>">Supprimer</a>
        </div>
        </div>
    <?php echo HTMLInsertFooter(); ?>
</body>
</html>
