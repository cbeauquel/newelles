<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>

<div class="newelleList">
    <?php foreach($newelles as $newelle) { ?>
        <article class="newelle">
            <h2><?= $newelle->getTitle() ?></h2>
            <img src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle" />
            <a href="<?= $newelle->getAudio() ?>">Cliquez pour écouter !</a>
            <p><?= $newelle->getContent(400) ?></p>
            
            <div class="footer">
                <span class="info"> <?= ucfirst(Utils::convertDateToFrenchFormat($newelle->getDateCreation())) ?></span>
                <a class="info" href="index.php?action=shownewelle&id=<?= $newelle->getId() ?>">Lire +</a>
            </div>
    </article>
    <?php } ?>
</div>