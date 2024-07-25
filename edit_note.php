<?php
require 'conf.php';
require 'app/fcts-tools.php';
require 'app/fcts-app.php';
require 'app/fcts-html.php';

// Récupérer l'identifiant de la note à éditer depuis l'URL
$note_id = $_GET['id'] ?? '';

if (empty($note_id)) {
    die('Aucun identifiant de note spécifié.');
}

// Récupérer les détails de la note à éditer
$note = LOADNoteFromFile($note_id);

// Debug : Vérifier que la note a bien été chargée
if ($note === false) {
    die('La note spécifiée est introuvable.');
}

// Traitement du formulaire d'édition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'identifiant de la note depuis les données POST
    $note_id = $_POST['note_id'] ?? '';

    if (empty($note_id)) {
        die('Aucun identifiant de note spécifié.');
    }

    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $type = $_POST['type'] ?? 'note';
    $favoris = isset($_POST['favoris']) ? 1 : 0;

    // Mettre à jour la note
    $result = UPDATENoteFile([
        'title' => $title,
        'content' => $content,
        'type' => $type,
        'favoris' => $favoris,
        'file' => $note_id,
        'date' => date("d-m-Y H:i:s")
    ]);

    if ($result) {
        addMessage('Note mise à jour avec succès.', 'success');
        // Rediriger vers la page principale après la mise à jour
        header("Location: index.php");
        exit();
    } else {
        addMessage('Erreur lors de la mise à jour de la note.', 'error');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <?php echo HTMLInsertHeader(); ?>
    <link rel="stylesheet" href="./assets/css/styles.css">
<body>

    <header>
        <img src="./img/Duckspace.png" alt="image">
    </header>

    <!-- Menu -->
    <nav>
        <?php echo HTMLInsertMenu(); ?>
    </nav>
    <hr>     

    <div class="container-edit-note">
        <h1>Éditer une note</h1>
        <form method="post">
            <div class = "title-type">
                <input type="hidden" name="note_id" value="<?php echo htmlspecialchars($note_id); ?>">
                <label for="title">Titre</label><br>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($note['title']); ?>"><br>
                <label for="type">Type</label><br>
                <select id="type" name="type">
                    <option value="link" <?php echo ($note['type'] == 'link') ? 'selected' : ''; ?>>Lien</option>
                    <option value="code" <?php echo ($note['type'] == 'code') ? 'selected' : ''; ?>>Code source</option>
                    <option value="text" <?php echo ($note['type'] == 'text') ? 'selected' : ''; ?>>Texte contextuel</option>
                </select><br>
            </div>
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content"><?php echo htmlspecialchars($note['content']); ?></textarea><br>
            
            <div class = "check-box_favoris">
                <input type="checkbox" id="favoris" name="favoris" <?php echo ($note['favoris'] == 1) ? 'checked' : ''; ?>>
                <label for="favoris" id="favoris">Favoris</label><br>
            </div>
            <div class = "Container-buttons">
                <button type="submit">Modifier</button>
                <a href="index.php">Annuler</a>
            </div>
        </form>
        <?php echo HTMLInsertFooter(); ?>
    </div>
</body>
</html>
