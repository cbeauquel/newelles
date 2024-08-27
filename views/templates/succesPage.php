<?php
    /**
     * Template pour afficher une page d'erreur.
     */
?>

<div class="error">
    <div class="signature">
        <h1>Succès</h1>
    </div>
    <h2>L'opération est effectuée</h2>
    <p><?= $succesMessage ?></p>
    <a href="index.php?action=<?= $redirect ?>">Continuer</a>
</div>
