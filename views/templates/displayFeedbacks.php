<?php
    /**
     * Affichage de Liste des feedbacks. 
     */
?>
<div class="signature">
    <h1>Compte utilisateur</h1>
</div>

<div class="newelleList">
    <h2>Gestion des Feedbacks</h2>
    <?php 
    if (empty($userFeedbacks))
        {?>
            <h3>Vous n'avez pas encore eu de feedbacks</h3>
        <?php } else {
            Utils::createTable($userFeedbacks);
        }?>
    <nav class="nwlMngmt">
        <div class="nav">
            <a class="button" href="index.php?action=userAccount" title="revenir au compte utilisateur">Retour</a>
        </div>
    </nav>
</div>