<?php
    /**
     * Affichage du profil utilisateur. 
     */
?>
    <article class="detail">
        <div class="newelle-detail">
            <div class="meta-data">
                <h1><?= $profile->getStageName() ?></h1>
                <img class="detail-img" src="<?= $profile->getUsrImg() ?>" alt="Illustration du profil" >

            </div>
            <div class="newelle-text">            
                <?= $profile->getBio()?>
            </div>
        </div>
    </article>
    <div class="newelle-list">
    <?php 
    if (!empty($newelles))
        {?>
        <h2 class="profile-display">Les Newelles de <?=$profile->getStageName() ?></h2>
        <?php
        foreach($newelles as $newelle) { ?>
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
        <?php } 
        } else {?>
            <h2 class="profile-display"><?= $profile->getStageName()?> n'a pas encore publié de Newelles.</h3><?php
        }?>
    </div>    

