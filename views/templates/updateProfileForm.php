<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>

<div class="connection-form">
    <form action="index.php" method="post" class="foldedCorner" enctype="multipart/form-data">
        <h2>Modification de votre profil utilisateur</h2>
        <div class="formGrid">
            <label for="email">Votre email</label>
            <input type="text" name="email" id="email" required value="<?=$profile->getEmail() ?>">
            <label for="name">Votre Nom (Nom de famille)</label>
            <input type="text" name="name" id="name" value="<?= $profile->getName() ?>" required>
            <label for="firstName">Votre prénom</label>
            <input type="text" name="firstName" id="firstName" value="<?= $profile->getFirstName() ?>" required>
            <label for="stageName">Votre nom d'auteur</label>
            <input type="text" name="stageName" id="stageName" value="<?= $profile->getStageName() ?>" required>
            <label for="bio">Présentez-vous !</label>
            <textarea class="saisie-input" id="rtf" name="bio" cols="150" rows="100"><?= $profile->getBio() ?></textarea>
            <label for="currentImg">Votre photo de profil actuelle</label>
            <img class="current-img" src="<?= $profile->getUsrImg() ?>" alt="Image actuelle" />
            <input type="hidden" value="<?=$profile->getUsrImg() ?>" name="currentImg" id="currentImg">
            <label class="nwl-img-lbl" for="usrImg">Insérez une nouvelle image d'illustration (fichiers acceptés : jpg, png)</label>
            <input class="nwl-img-input" type="file" name="usrImg" id="usrImg">
            <input type="hidden" name="action" value="updateProfile">          
            <button class="submit">Modifier</button>
        </div>
    </form>
</div>