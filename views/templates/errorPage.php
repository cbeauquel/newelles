<?php
    /**
     * Template pour afficher une page d'erreur.
     */
?>

<div class="error">
    <div class="signature">
        <h1>Quelque chose ne s'est pas passé comme prévu</h1>
    </div>
    <h2>Erreur</h2>
    <p><?= $errorMessage ?></p>
    <a href="index.php?action=home">Retour à la page d'accueil</a>
</div>
