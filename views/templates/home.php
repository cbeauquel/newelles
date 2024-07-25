<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>

<div class="newelleList">
    <h2>Les dernières Newelles</h2>
    <?php foreach($newelles as $newelle) { ?>
        <article class="home">
            <a href="index.php?action=detail&id=<?= $newelle->getId()?>" title="voir le détail">
                <div class="newelle">
                    <div class="newelle-content">
                        <h3><?= $newelle->getTitle() ?></h3>
                        <p class="stagename">proposé par <?= $newelle->getStageName()?></p>
                        <p><?= $newelle->getContent(500) ?></p>                        
                    </div>
                    <img class="newelle-img" src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle" />
                    <div class="newelle-footer">
                        <div class="info"><?= $newelle->getGenre() ?></div>
                        <div class="info"><?= $newelle->getDuree() ?>&nbsp;mn</div>
                        <div class="info"><?= $newelle->getTaille() ?>&nbsp;mots</div>
                        <span class="info"><?= ucfirst(Utils::convertDateToFrenchFormat($newelle->getDateCreation())) ?></span>                       
                    </div>
                </div>
                </a>
        </article>
    <?php } ?>
</div>