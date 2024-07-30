<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>

<div class="newelleList">
    <h2>Gestion des Newelles</h2>
    <?php 
    if (empty($newellesUser))
        {?>
            <h3>Vous n'avez pas encore publié de newelles, cliquez sur "ajouter une Newelle" pour débuter</h3>
        <?php } else {
            Utils::createTable($newellesUser);
        }?>
    <nav class="nwlMngmt">
        <div class="nav">
            <a class="submit" href="index.php?action=addNewelle" title="ajouter une newelle">Ajouter une Newelle</a>
        </div>
    </nav>
</div>