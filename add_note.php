<?php 

require 'app/fcts-html.php';

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

    <div class="container-edit-note">
        <h1>Ajouter une note</h1>
        <form action="index.php?page=add_note" method="post">
            <div class = "title-type">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required>
                <label for="type">Type :</label>
                <select name="type" id="type" require>
                    <option value="note">Note textuelle</option>
                    <option value="code">Code sourse</option>
                    <option value="lien">Lien / Url</option>
                </select>
            </div>
            <label for="content">Contenu :</label>
            <textarea id="content" name="content" required></textarea>

            <div class = "check-box_favoris">
                <label for="favoris">Favoris :</label>
                <input type="checkbox" id="favoris" name="favoris" value="1">
            </div>
            <div class = "Container-buttons">
                <button type="submit" name="add_note">Ajouter</button>
                <a href="index.php">Annuler</a>
            </div>
        </form>
    </div>

<!-- footer -->
<?php echo HTMLInsertFooter(); ?>    


</body>
</html>