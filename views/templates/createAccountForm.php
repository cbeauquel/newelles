<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>
<h1>Créer un compte</h1>
<div class="form">
    <form action="index.php?action=createUser" method="post">
        <fieldset class="form-grid">
        <legend><strong>Vous ne semblez pas avoir de compte.</strong><br> Si vous souhaitez publier une Newelle, vous pouvez créer un compte en remplissant les champs ci-dessous : </legend>
            <label for="email">email</label>
            <input type="text" name="email" id="email" required value="<?=$userDatas['email'] ?>">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required value="<?=$userDatas['password']?>">
            <label for="confirm_password">Confirmez le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <label for="name">Votre Nom (Nom de famille)</label>
            <input type="text" name="name" id="name" required>
            <label for="firstName">Votre prénom</label>
            <input type="text" name="firstName" id="firstName" required>
            <label for="stageName">Votre nom d'auteur</label>
            <input type="text" name="stageName" id="stageName" required>
        </fieldset>
        <button class="submit">Créer un compte</button>
    </form>
</div>