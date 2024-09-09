<?php
    /**
     * Template pour afficher une page d'erreur.
     */
?>
<h1>Erreur</h1>
<div class="error">
    <h2>Quelque chose ne s'est pas passé comme prévu</h2>
    <p><?= $errorMessage ?></p>
    <a href="index.php?action=home">Retour à la page d'accueil</a>
</div>
