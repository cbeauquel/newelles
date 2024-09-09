<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>
<h1>Connexion / inscription</h1>
<div class="form">
    <form action="index.php?action=connectUser" method="post" aria-label="connexion ou création d'un compte utilisateur">
        <fieldset class="form-grid">
        <legend>Pour vous inscrire, saisissez votre adresse e-mail et un mot de passe de votre choix. <br>Cliquez sur "Se connecter / s'inscrire" pour finaliser la création du compte.</legend>
            <label for="email">e-mail</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <a class="underline grid-input" href="index.php?action=displayResetPassword" title="Réinitialiser le mot de passe">Mot de passe oublié ?</a>
        </fieldset>
            <button class="submit">Se connecter / s'inscrire</button>
    </form>
</div>