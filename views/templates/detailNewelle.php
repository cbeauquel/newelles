<?php
    /**
     * Affichage de Liste des newelles. 
     */
?>
    <article class="detail">
        <div class="newelle-detail">
            <div class="meta-data">
                <h2><?= $newelle->getTitle() ?></h2>
                <ul>
                    <li>Proposé par : 
                    <strong><a href="index.php?action=displayProfile&id=<?= $newelle->getIdUser()?>" title="voir le profil de <?= $newelle->getStageName()?>"> 
                    <?= htmlspecialchars($newelle->getStageName()) ?>
                    </a></strong></li>
                    <li>Genre : <strong><?= htmlspecialchars($newelle->getGenre() )?></strong></li>
                    <li>Taille : <strong><?= htmlspecialchars($newelle->getTaille()) ?></strong></li>
                    <li>Durée : <strong><?= htmlspecialchars($newelle->getDuree()) ?></strong></li>
                    <li>Ajoutée le : <strong><?= ucfirst(Utils::convertDateToFrenchFormat($newelle->getDateCreation())) ?></strong></li>
                </ul>
                <img class="detail-img" src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle" />
            </div>
            <div class="newelle-text">            
                <div class="audio-player">
                    <audio id="audio" src="<?= $newelle->getAudio() ?>"></audio>
                    <button class="material-symbols-outlined" id="playPauseButton">play_circle</button>
                </div>
                <p>
                    <?= $newelle->getContent() ?>
                </p>
            </div>
        </div>
        <?php if (isset($_SESSION['user'])){?>
            <nav class="nwlMngmt">
            <div class="nav">
                <a class="submit" href="index.php?action=showUpdateNewelleForm&id=<?=$newelle->getId()?>" title="modifier une newelle">Modifier</a>
            </div>
            </nav>
        <?php }?>
    </article>
