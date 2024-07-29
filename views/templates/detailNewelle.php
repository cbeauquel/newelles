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
                    <li>Proposé par : <strong><?= htmlspecialchars($newelle->getStageName()) ?></strong></li>
                    <li>Genre : <strong><?= htmlspecialchars($newelle->getGenre() )?></strong></li>
                    <li>Taille : <strong><?= htmlspecialchars($newelle->getTaille()) ?>&nbsp;mots</strong></li>
                    <li>Durée : <strong><?= htmlspecialchars($newelle->getDuree()) ?>&nbsp;mn</strong></li>
                    <li>Ajoutée le : <strong><?= ucfirst(Utils::convertDateToFrenchFormat($newelle->getDateCreation())) ?></strong></li>
                </ul>
                <img src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle" />
            </div>
            <div class="newelle-text">
                <a href="<?=$newelle->getAudio() ?>" target="_blank" title="écoutez"><div class="material-symbols-outlined">play_circle</div></a>
                <p>
                    <?= Utils::format($newelle->getContent()) ?>
                </p>
            </div>
        </div>
    </article>
