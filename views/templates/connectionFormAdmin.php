<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>

<div class="connection-form">
    <form action="index.php?action=connectAdmin" method="post" class="folded-corner">
        <h2>Connexion Administrateur</h2>
        <div class="formGrid">
            <label for="email">e-mail</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <button class="submit">Se connecter</button>
        </div>
    </form>
</div>