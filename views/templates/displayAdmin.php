<?php 
    /** 
     * Affichage du back office
     */
?>
<h2>Page d'administration</h2>
<div class="stats-container">
    <div class="stat">
        <h3>Nombre total de Newelles</h3>
        <div><p><?= $nbNewelles['Number of Newelles'] ?></p></div>
    </div>
    <div class="stat">
        <h3>Nombre total de Newellers</h3>
        <div><p><?= $nbNewellers['Number of Newellers'] ?></p></div>

    </div>
    <div class="stat">
        <h3>Nombre total de Feedbacks</h3>
        <div><p><?= $nbFeedbacks['Number of Feedbacks'] ?></p></div>
    </div>
    <div class="stat">
        <h3>La newelle la mieux notée</h3>
        <div><p><?= $bestNewelle['title'] ?></p></div>
        <div><p><?= $bestNewelle['views'] ?></p>vues</div>
        <div><p><?= $bestNewelle['pouces'] ?></p>coups de pouce</div>
        <div><p><?= $bestNewelle['commentaires'] ?></p>commentaire(s)</div>

    </div>
    <div class="stat">
        <h3>Le neweller le plus actif</h3>
        <div><p><?= $bestNeweller['stagename'] ?></p></div>
        <div><p><?= $bestNeweller['newelles'] ?></p>newelles</div>
        <div><p><?= $bestNeweller['views'] ?></p>vues</div>
        <div><p><?= $bestNeweller['pouces'] ?></p>coups de pouce</div>
        <div><p><?= $bestNeweller['commentaires'] ?></p>commentaire(s)</div>
    </div>
    <div class="stat">
        <h3>Le lecteur le plus actif</h3>
        <div><p><?= $bestReader['nickname'] ?></p></div>
        <div><p><?= $bestReader['newelles'] ?></p>newelles commentées</div>
        <div><p><?= $bestReader['pouces'] ?></p>coups de pouce donnés</div>
        <div><p><?= $bestReader['commentaires'] ?></p>Feedbacks publiés</div>
    </div>

</div>


