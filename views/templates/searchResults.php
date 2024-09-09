<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>

<div class="newelle-list">
    <h1>Votre recherche</h1>
    <h2>Les newelles trouvées selon vos mots clés :</h2>
    <?php foreach($newelles as $newelle) { ?>
        <article class="home-newelles">
            <a href="index.php?action=detail&id=<?= $newelle->getId()?>" title="Consulter la newelle <?= $newelle->getTitle() ?>">
                <div class="newelle">
                    <div class="newelle-content">
                        <h3><?= $newelle->getTitle() ?></h3>
                        <p class="stagename">par <?= $newelle->getStageName()?></p>
                        <p class="extrait"><?= utils::format($newelle->getContent(),1,295) ?></p>                        
                    </div>
                    <img class="newelle-img" src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle <?= $newelle->getTitle() ?>">
                    <ul class="newelle-footer">
                        <li class="info"><?= $newelle->getGenre() ?></li>
                        <li class="info"><?= $newelle->getDuree() ?></li>
                        <li class="info"><?= $newelle->getTaille() ?></li>
                        <li class="info"><?= ucfirst(Utils::convertDateToFrenchFormat($newelle->getDateCreation())) ?></li>
                    </ul>
                </div>
                </a>
        </article>
    <?php } ?>
</div>
