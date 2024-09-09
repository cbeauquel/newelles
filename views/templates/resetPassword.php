<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>
<h1>Réinitialisation du mot de passe</h1>
<div class="form">
    <?php if($token) {?>
    <form action="index.php?action=updatePassword" method="post" aria-label="Mise à jour du password">
    <?php } else { ?>
    <form action="index.php?action=resetPassword" method="post" aria-label="Réinitialisation du password">
    <?php } ?>
        <div class="form-grid">
            <?php if($token) {?>
                <label for="password">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required>
                <label for="confirm_password">Confirmez le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <input type="hidden" name="token" id="token" value="<?= $token ?>">
                <?php } else { ?>
                <label for="email">e-mail</label>
                <input type="text" name="email" id="email" required>
                <?php } ?>
        </div>
        <button class="submit">Réinitialiser</button>
    </form>
</div>