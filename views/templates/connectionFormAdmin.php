<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>
<h1>Connexion Administrateur</h1>
<div class="form">
    <form action="index.php?action=connectAdmin" method="post" class="folded-corner">
        <fieldset class="form-grid">
        <legend>Seul les profils administrateurs peuvent se connecter</legend>
            <label for="email">e-mail</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </fieldset>
        <button class="submit">Se connecter</button>
    </form>
</div>