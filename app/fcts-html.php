<?php

//ajout du configuration dans les fontions HTML
require_once 'conf.php';

//creation de la structure HTML

function HTMLInsertHeader() {
    return  '

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>';
}

// function pour inserer le banner le l'application
function HTMLInsertBanner() {
    return '<div class="banner"><h1>' . APP_NAME . '</h1></div>';
}

// function pour inserer le menu
function HTMLInsertMenu() {
    return '
    <nav>
        <ul>
            <li><a href="index.php">Acceuil</a></li>
            <li><a href="add_note.php">Ajouter une note</a></li>
        </ul>
    </nav>';
}

// function pour inserer le footer
function HTMLInsertFooter() {
    return '<footer><p>&copy; ' . date('Y') . ' ' . APP_NAME . '</p></footer>';
}

function HTMLInsertFormSortNote() {
    $selected_options = SORTManager($_GET['sort_by'] ?? SORT_BY_DEFAULT, $_GET['sort_order'] ?? SORT_ORDER_DEFAULT);
    return '
    <form method="GET" action="index.php">
        <select name="sort_by">
            <option value="' . SORT_BY_DATE . '" ' . $selected_options['selected'][SORT_BY_DATE] . '>Date</option>
            <option value="' . SORT_BY_TITLE . '" ' . $selected_options['selected'][SORT_BY_TITLE] . '>Titre</option>
            <option value="' . SORT_BY_TYPE . '" ' . $selected_options['selected'][SORT_BY_TYPE] . '>Type</option>
            <option value="' . SORT_BY_FAVORIS . '" ' . $selected_options['selected'][SORT_BY_FAVORIS] . '>Favoris</option>
        </select>
        <select name="sort_order">
            <option value="' . SORT_ORDER_ASC . '" ' . $selected_options['selected_order'][SORT_ORDER_ASC] . '>Ascendant</option>
            <option value="' . SORT_ORDER_DESC . '" ' . $selected_options['selected_order'][SORT_ORDER_DESC] . '>Descendant</option>
        </select>
        <input type="text" name="search" placeholder="Rechercher...">
        <button type="submit">Trier/Rechercher</button>
    </form>';
}


function HTMLInsertNotes($notes) {
    $output = '<div class="notes">';
    foreach ($notes as $note) {
        $output .= '<div class="note"><h2>' . htmlspecialchars($note['title']) . '</h2><p>' . htmlspecialchars($note['content']) . '</p><p>Type: ' . htmlspecialchars($note['type']) . '</p><p>Date: ' . htmlspecialchars($note['date']) . '</p></div>';
    }
    $output .= '</div>';
    return $output;
}

function HTMLDisplayNotes($notes) {
    $output = '<div class="notes">';
    foreach ($notes as $note) {
        $output .= '<div class="note-tile">';
        $output .= '<h2>' . htmlspecialchars($note['title']) . '</h2>';
        $output .= '<p>Type: ' . htmlspecialchars($note['type']) . '</p>';
        $output .= '<p>Date: ' . htmlspecialchars($note['date']) . '</p>';
        $output .= '<a href="view_note.php?file=' . urlencode($note['filename']) . '">Voir la note</a>';
        $output .= '</div>';
    }
    $output .= '</div>';
    return $output;
}

function HTMLDisplayFavorites($favorites) {
    $output = '<div class="favorites">';
    foreach ($favorites as $note) {
        $output .= '<div class="favorite-tile">';
        $output .= '<h2>' . htmlspecialchars($note['title']) . '</h2>';
        $output .= '<p>Type: ' . htmlspecialchars($note['type']) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';
    return $output;
}
?>