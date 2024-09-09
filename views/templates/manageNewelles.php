<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>
<h1>Compte utilisateur</h1>
<div class="user-page">
    <h2>Gestion des Newelles</h2>
    <?php 
    if (empty($newellesUser))
        {?>
            <h3>Vous n'avez pas encore publié de newelles, cliquez sur "ajouter une Newelle" pour débuter</h3>
        <?php } else {
            Utils::createTable($newellesUser);
        }?>
    <nav>
        <a class="button" href="index.php?action=addNewelle" title="ajouter une newelle">Ajouter une Newelle</a>
        <a class="button" href="index.php?action=userAccount" title="revenir au compte utilisateur">Retour</a>
    </nav>
</div>