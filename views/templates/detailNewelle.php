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
                    <?= htmlspecialchars($newelle->getStageName()) ?><br>
                    <em><a href="index.php?action=displayProfile&id=<?= $newelle->getIdUser()?>" title="voir le profil de <?= $newelle->getStageName()?>"> 
                    Voir les Newelles de ce Neweller.
                    </a></em></li>
                    <li>Genre : <strong><?= htmlspecialchars($newelle->getGenre() )?></strong></li>
                    <li>Taille : <strong><?= htmlspecialchars($newelle->getTaille()) ?></strong></li>
                    <li>Durée : <strong><?= htmlspecialchars($newelle->getDuree()) ?></strong></li>
                    <li>Ajoutée le : <strong><?= ucfirst(Utils::convertDateToFrenchFormat($newelle->getDateCreation())) ?></strong></li>
                </ul>
                <img class="detail-img" src="<?= $newelle->getNwlImg() ?>" alt="Illustration de la newelle" />

                <div class="feedbacks">
                    <h3>Les commentaires à propos de cette Newelle</h3>
                    <div class="feedback">
                        <?php 
                            if (empty($feedbacks)) {
                                echo '<p class="no-comment">Aucun commentaire pour cette Newelle.</p>';
                            } else {
                                echo '<ul>';
                                foreach ($feedbacks as $feedback){
                                    echo '<li>';
                                    echo '  <div class="detailFeedback">';
                                    echo '      <h4 class="info">Le ' . Utils::convertDateToFrenchFormat($feedback->getDateComment()) . ", "
                                                                      . htmlspecialchars($feedback->getNickName()) . ' a écrit :</h3>';
                                    echo '      <p class="content">' .htmlspecialchars($feedback->getComment()) . '</p>';
                                    if ($feedback->getThumbUp() > 0){
                                    echo '      <p class="info">et a donné :</p>';
                                    for ($i = 0; $i < $feedback->getThumbUp(); $i++){
                                        echo '  <span class="material-symbols-outlined">Thumb_Up</span>'; }
    
                                    echo '   <p class="info">coups de pouce</p></div>'; }
                                    echo '</li>';
                                }               
                                echo '</ul>';
                            } 
                        ?>
                    </div>
                    <h3>Ajoutez votre avis et votre coup de pouce !</h3>
                    <form class="feedback-form" action="index.php?action=addFeedback" method="post" class="foldedCorner">
                        <label for="comment">Saisissez un commentaire !</label>
                        <textarea id="comment" name="comment" cols="40" rows="30" placeholder="Votre commentaire ici"></textarea>
                        <label for="thumbup">Vous pouvez ajouter un coup de pouce !</label>
                            <div class="rating">
                            <!-- l'ordre des pouces est inversé (mode décroissant)-->
                                <input type="radio" id="thumbup5" name="rating" value="5">
                                <label class="material-symbols-outlined" for="thumbup5">Thumb_Up</label>
                                <input type="radio" id="thumbup4" name="rating" value="4">
                                <label class="material-symbols-outlined" for="thumbup4">Thumb_Up</label>
                                <input type="radio" id="thumbup3" name="rating" value="3">
                                <label class="material-symbols-outlined" for="thumbup3">Thumb_Up</label>
                                <input type="radio" id="thumbup2" name="rating" value="2">
                                <label class="material-symbols-outlined" for="thumbup2">Thumb_Up</label>
                                <input type="radio" id="thumbup1" name="rating" value="1" checked>
                                <label class="material-symbols-outlined" for="thumbup1" >Thumb_Up</label>
                            </div>
                        <label for="nickname">Indiquez un pseudo</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Votre pseudo">
                        <input type="hidden" id="nwlId" name="nwlId" value="<?= $newelle->getId() ?>">
                        <div class="h-captcha" data-sitekey="86a4d0e6-4e9e-422a-9c1e-c25e6cdcba62"></div>
                        <button class="submit">Soumettre</button>
                    </form>
                </div>
            </div>
            <div class="newelle-text">    
                <?php if(!empty($newelle->getAudio()))
                { ?>        
                <div class="audio-player">
                    <audio id="audio" src="<?= $newelle->getAudio() ?>"></audio>
                    <button class="material-symbols-outlined" id="playPauseButton">play_circle</button>
                </div>
                <?php } ?>
                <p>
                    <?= utils::displayTextPerPage($newelle->getContent(), 2000) ?>
                </p>
            </div>
        </div>
        <?php 
;
        if ($_SESSION['idUser'] === $newelle->getIdUser()) {?>
            <nav class="nwlMngmt">
            <div class="nav">
                <a class="submit" href="index.php?action=showUpdateNewelleForm&id=<?=$newelle->getId()?>" title="modifier une newelle">Modifier</a>
            </div>
            </nav>
        <?php }?>
    </article>
