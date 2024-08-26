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
    if (!empty($profileNewelles))
        {?>
        <h2 class="profile-display">Les Newelles de <?=$profile->getStageName() ?></h2>
        <?php
        foreach($profileNewelles as $profileNewelle) { ?>
            <article class="home-newelles">
                <a href="index.php?action=detail&id=<?= $profileNewelle->getId()?>" title="Consulter la newelle <?= $profileNewelle->getTitle() ?>">
                    <div class="newelle">
                        <div class="newelle-content">
                            <h3><?= $profileNewelle->getTitle() ?></h3>
                            <p class="stagename">proposé par <?= $profileNewelle->getStageName()?></p>
                            <p class="extrait"><?= utils::format($profileNewelle->getContent(),1,295); ?></p>                        
                        </div>
                        <img class="newelle-img" src="<?= $profileNewelle->getNwlImg() ?>" alt="Illustration de la newelle <?= $profileNewelle->getTitle() ?>" >
                        <div class="newelle-footer">
                            <div class="info"><?= $profileNewelle->getGenre() ?></div>
                            <div class="info"><?= $profileNewelle->getDuree() ?></div>
                            <div class="info"><?= $profileNewelle->getTaille() ?></div>
                            <span class="info"><?= ucfirst(Utils::convertDateToFrenchFormat($profileNewelle->getDateCreation())) ?></span>                       
                        </div>
                    </div>
                    </a>
            </article>
        <?php } 
        } else {?>
            <h2 class="profile-display"><?= $profile->getStageName()?> n'a pas encore publié de Newelles.</h3><?php
        }?>
    </div>    

