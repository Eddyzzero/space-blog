<?php
require 'conf.php';
require 'app/fcts-tools.php';
require 'app/fcts-app.php';
require 'app/fcts-html.php';

// Récupérer l'identifiant de la note à supprimer depuis l'URL
$note_filename = $_GET['file'] ?? '';

// Vérifier si aucun fichier n'est spécifié
if (!$note_filename) {
    die('Aucun fichier spécifié.');
}

// Charger les détails de la note à supprimer
$note = LOADNoteFromFile($note_filename);

// Vérifier si la note existe
if (!$note) {
    die('Note non trouvée.');
}

// Confirmation de suppression uniquement si le paramètre confirm est présent dans l'URL
if(isset($_GET['confirm'])){
    // Supprimer la note
    $result = DELETENoteFile($note_filename);

    if ($result) {
        addMessage('Note supprimée avec succès.', 'success');
    } else {
        addMessage('Erreur lors de la suppression de la note.', 'error');
    }

    // Rediriger vers la page principale après la suppression
    header("Location: index.php");
    exit();
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
    <div class="container-delete">
        <div class="container-delete-note"> 
            <div class="alert-warning">
                Souhaitez-vous vraiment supprimer cette note ? <br> 
                <strong><?php echo htmlspecialchars($note['title']); ?></strong>
            </div>            
            <div class = "Container-buttons-delete">
                <!-- Lien pour confirmer la suppression avec ajout du paramètre confirm -->
                <a href="delete_note.php?file=<?php echo urlencode($note_filename); ?>&confirm" class="btn btn-outline-danger">Confirmer</a>
                <!-- Lien pour annuler la suppression -->
                <a href="index.php?page=view_note&file=<?php echo urlencode($note_filename); ?>" class="btn btn-outline-success">Annuler</a>
            </div>                  
        </div>
    </div>
</body>
</html>
