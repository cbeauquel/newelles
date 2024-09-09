<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>
<h1>Écoutez, lisez, partagez des histoires originales !</h1>

<section class="newelle-list">        
    <h2>Les 6 dernières Newelles</h2>
    <?php foreach($newelles as $newelle) { ?>
        <article class="home-newelles">
            <a href="index.php?action=detail&id=<?= $newelle->getId()?>" title="Consulter la newelle <?= $newelle->getTitle() ?> ">
                <div class="newelle">
                    <div class="newelle-content">
                        <h3><?= $newelle->getTitle() ?></h3>
                        <p class="stagename">par <?= $newelle->getStageName()?></p>
                        <p class="extrait"><?= utils::format($newelle->getContent(),1,330) ?></p>                        
                    </div>
                    <img class="newelle-img" src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle <?= $newelle->getTitle() ?>" >
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
    <div class="center"><a class="button" href="index.php?action=displayAllNewelles" title="Voir toutes les newelles">Voir tout</a></div>
</section>
<section class="newelle-list"> 
    <h2>Top 4 Newellers</h2>
    <?php foreach($profiles as $profile) { ?>
        <article class="home-profiles">
            <a href="index.php?action=displayProfile&id=<?= $profile->getId()?>" title="voir le détail de <?= $profile->getStageName() ?>">
                <div class="profile">
                    <img class="profile-img" src="<?= $profile->getUsrImg() ?>" alt="Illustration du profil <?= $profile->getStageName() ?>" >
                    <div class="profile-content">
                        <h3><?= $profile->getStageName() ?></h3>
                        <p><?= utils::format($profile->getBio(),0,210) ?></p>                        
                    </div>
                </div>
            </a>
        </article>
    <?php } ?>
</section>
