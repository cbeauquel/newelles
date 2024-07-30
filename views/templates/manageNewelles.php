<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>

<div class="newelleList">
    <h2>Gestion des Newelles</h2>
    <?php Utils::createTable($newellesUser);?>
    <nav class="nwlMngmt">
        <div class="nav">
            <a class="submit" href="index.php?action=addNewelle" title="ajouter une newelle">Ajouter une Newelle</a>
        </div>
    </nav>
</div>