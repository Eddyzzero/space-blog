<?php
// *******************************************************
// --                    CONTROLLER                     --
// *******************************************************
require 'conf.php';
require 'app/fcts-tools.php';
require 'app/fcts-html.php';
require 'app/fcts-app.php';

// DEBUG
// T_Printr($_POST, 'POST');
// T_Printr($_GET, 'GET');   

// Initialisation des variables
$sort_by = $_GET['sort_by'] ?? SORT_BY_DEFAULT;
$sort_order = $_GET['sort_order'] ?? SORT_ORDER_DEFAULT;
$search = $_GET['search'] ?? '';
$section_notes = '';
$section_message = '';
$section_favoris = '';

// Tri des notes
$notes = GETListAllNotes();
$notes = GETNotesSortedBy($notes, $sort_by, $sort_order);

// Gestion de l'affichage des pages et de leur contenu
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'view_note':
        $filename = $_GET['file'] ?? '';
        if ($filename) {
            $note = LOADNoteFromFile($filename);
            if ($note) {
                $content = '<h1>' . htmlspecialchars($note['title']) . '</h1>';
                $content .= '<p>' . nl2br(htmlspecialchars($note['content'])) . '</p>';
                $content .= '<p>Type: ' . htmlspecialchars($note['type']) . '</p>';
                $content .= '<p>Date: ' . htmlspecialchars($note['date']) . '</p>';
            } else {
                $content = '<p>Note non trouvée.</p>';
            }
        } else {
            $content = '<p>Fichier non spécifié.</p>';
        }
        break;

    case 'add_note':
        ob_start();
        include 'add_note_form.php';
        $content = ob_get_clean();
        break;

    case 'home':
    default:
        $content = HTMLInsertFormSortNote();
        $content .= $section_message;
        $content .= $section_notes;
        $content .= $section_favoris;
        break;
}

// Gestion des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_note'])) {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $type = $_POST['type'] ?? 'note';
        $favoris = isset($_POST['favoris']) ? 1 : 0;

        if ($title && $content) {
            $result = ADDNewNoteToFile($title, $content, $type, $favoris);
            if ($result) {
                addMessage('Note ajoutée avec succès.', 'success');
            } else {
                addMessage('Erreur lors de l\'ajout de la note.', 'error');
            }
        } else {
            addMessage('Le titre et le contenu sont obligatoires.', 'warning');
        }
    } elseif (isset($_POST['edit_note'])) {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $type = $_POST['type'] ?? 'note';
        $favoris = isset($_POST['favoris']) ? 1 : 0;
        $filename = $_POST['filename'] ?? '';

        if ($title && $content && $filename) {
            $note_record = [
                'title' => $title,
                'content' => $content,
                'type' => $type,
                'favoris' => $favoris,
                'file' => $filename,
                'date' => date("d-m-Y H:i:s")
            ];
            $result = UPDATENoteFile($note_record);
            if ($result) {
                addMessage('Note mise à jour avec succès.', 'success');
            } else {
                addMessage('Erreur lors de la mise à jour de la note.', 'error');
            }
        } else {
            addMessage('Le titre, le contenu et le fichier sont obligatoires.', 'warning');
        }
    }
}

// Recherche des notes
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search_note'])) {
    $search = $_GET['search'] ?? '';
    $notes = GETListAllNotes();
    if ($search) {
        $notes = SEARCHInNotes($notes, $search);
    }
    $section_notes = HTMLInsertNotes($notes);
} else {
    $notes = GETListAllNotes();
    $notes = GETNotesSortedBy($notes, $sort_by, $sort_order);
    $section_notes = HTMLInsertNotes($notes);
}

// Affichage des messages
$section_message = '';

?>
<!DOCTYPE html>
<html lang="fr">
    <?php echo HTMLInsertHeader(); ?>
    <link rel="stylesheet" href="./assets/css/styles.css">

<body>

    <header>
        <img src="./img/Duckspace2.png" alt="image">
    </header>
    
        <!-- Menu -->
    <nav>
        <?php echo HTMLInsertMenu(); ?>
    </nav>
    <hr>     

    <div class="container-index">
        <!-- Affichage des messages -->       
        <?php echo $section_message; ?>

        <!-- Affichage des notes -->
        <div class="notes">
            <?php foreach ($notes as $note): ?>
            <div class="note">
                <a href="view_note.php?file=<?php echo urlencode($note['filename']); ?>">
                    <h2><?php echo htmlspecialchars($note['title']); ?></h2>
                </a>
                <p><?php echo nl2br(htmlspecialchars(substr($note['content'], 0, 100))); ?>...</p>
                <p>Type: <?php echo htmlspecialchars($note['type']); ?></p>
                <p>Date: <?php echo htmlspecialchars($note['date']); ?></p>
            </div>
            
            <?php endforeach; ?>
        </div>


        <!-- Affichage des favoris -->
        <?php echo $section_favoris ?>
        
    </div><!-- container -->     
    
    <!-- Footer -->
    <?php echo HTMLInsertFooter(); ?>    

    <!-- Scripts -->
</body>   
</html>
