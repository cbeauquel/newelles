<?php
    /**
     * Template pour afficher le formulaire de connexion.
     */
?>
<div class="signature">
    <h1>Compte utilisateur</h1>
</div>

<div class="connection-form">
    <form action="index.php" method="post" class="foldedCorner" enctype="multipart/form-data">
        <h2><?= $newelle->getId() == -1 ? "Création d'une Newelle" : "Modification de la Newelle "?></h2>
        <div class="formGrid">
            <label class="title-lbl" for="title">Titre de la Newelle</label>
            <input class="title-input" type="text" name="title" id="title" value="<?= $newelle->getTitle() ?>" required>
            <label class="genre-lbl" for="genre">Genre de la Newelle</label>
            <select class="genre-input" type="select" name="genre" id="genre" required>
                <option value="<?= $newelle->getGenre() ?>">Choisissez un genre</option>
                <option value="Romance">Romance</option>
                <option value="Aventure">Aventure</option>
                <option value="Policier">Policier</option>
                <option value="Épouvante">Épouvante</option>
                <option value="Historique">Historique</option>
                <option value="Conte">Conte</option>
                <option value="Science Fiction">Science Fiction</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Humour">Humour</option>
            </select>
            <label class="saisie-lbl">Saisissez votre Newelle ici</label>
            <textarea class="saisie-input" id="rtf" name="content" cols="150" rows="200"><?= $newelle->getContent() ?></textarea>
            <?php if($newelle->getId() == -1) {?>
                <label class="duree-lbl" for="duree">Durée de la Newelle en mn</label>
                <input class="duree-input" type="text" name="duree" id="duree" value="0">
                <label class="nwl-img-lbl" for="nwlImg">Insérez une image d'illustration (fichiers acceptés : jpg, png)</label>
                <input class="nwl-img-input" type="file" name="nwlImg" id="nwlImg">
                <label class="audio-lbl" for="audio">Insérez la piste audio de votre Newelle (mp3)</label>
                <input class="audio-input" type="file" name="audio" id="audio">
            <?php } else {?>
                <label class="duree-lbl" for="duree">Durée de la Newelle en mn</label>
                <input class="duree-input" type="text" name="duree" id="duree" value="<?= $newelle->getDuree() ?>">
                <label class="current-img-lbl" for="currentImg">Image actuelle :</label>
                <img class="current-img" src="<?=$newelle->getNwlImg() ?>" alt="Image actuelle" />
                <input type="hidden" value="<?=$newelle->getNwlImg() ?>" name="currentImg" id="currentImg">
                <label class="nwl-img-lbl" for="nwlImg">Insérez une nouvelle image d'illustration (fichiers acceptés : jpg, png)</label>
                <input class="nwl-img-input" type="file" name="nwlImg" id="nwlImg">
                <label class="current-audio-lbl" for="currentAudio">Piste audio actuelle :</label>
                <input class="current-audio-input" type="text" id="currentAudio" value="<?= $newelle->getAudio() ?>">
                <input type="hidden" value="<?= $newelle->getAudio() ?>" name="currentAudio" id="currentAudio">
                <label class="audio-lbl" for="audio">Insérez une nouvelle piste audio pour votre Newelle (mp3)</label>
                <input class="audio-input" type="file" name="audio" id="audio">
                <input type="hidden" name="idUser" value="<?= $newelle->getIdUser() ?>">
            <?php } ?>           
            <input type="hidden" name="action" value="updateNewelle">
            <input type="hidden" name="id" value="<?= $newelle->getId() ?>">
            <button class="submit"><?= $newelle->getId() == -1 ? "Ajouter" : "Modifier" ?></button>
        </div>
    </form>
</div>