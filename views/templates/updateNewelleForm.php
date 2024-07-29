<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>

<div class="connection-form">
    <form action="index.php" method="post" class="foldedCorner" enctype="multipart/form-data">
        <h2><?= $newelle->getId() == -1 ? "Création d'une Newelle" : "Modification de la Newelle "?></h2>
        <div class="formGrid">
            <label for="title">Titre de la Newelle</label>
            <input type="text" name="title" id="title" value="<?= $newelle->getTitle() ?>" required>
            <label for="genre">Genre de la Newelle</label>
            <input type="text" name="genre" id="genre" value="<?= $newelle->getGenre() ?>" required>
            <label for="taille">Taille de la Newelle en nombre de mots</label>
            <input type="text" name="taille" id="taille" placeholder="saisissez le nombre de mots de votre Newelle" value="<?= $newelle->getTaille() ?>" required>
            <label for="duree">Durée de la Newelle en minutes</label>
            <input type="text" name="duree" id="duree" value="<?= $newelle->getDuree() ?>" required>
            <label for="content">Saisissez votre Newelle ici</label>
            <textarea name="content" id="content" cols="150" rows="200" required><?= $newelle->getContent() ?></textarea>
            <label for="nwlImg">Insérez une image d'illustration (fichiers acceptés : jpg, png)</label>
            <input type="file" name="nwlImg" id="nwlImg" value="<?= $newelle->getNwlImg() ?>"/>
            <input type="hidden" name="action" value="updateNewelle">
            <input type="hidden" name="id" value="<?= $newelle->getId() ?>">
            <button class="submit"><?= $newelle->getId() == -1 ? "Ajouter" : "Modifier" ?></button>
        </div>
    </form>
</div>