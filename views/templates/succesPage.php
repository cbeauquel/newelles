<?php
    /**
     * Template pour afficher une page d'erreur.
     */
?>
<h1>Succès</h1>
<div class="error">
    <h2>L'opération est effectuée</h2>
    <p><?= $succesMessage ?></p>
    <a href="index.php?action=<?= $redirect ?>">Continuer</a>
</div>
