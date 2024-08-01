<?php 
    /** 
     * Affichage du compte utilisteur
     */
?>

<h2>Mon compte Newelles</h2>

<div class="account">
    <nav>
        <div class="account-card">
            <div class="account-card-title">
                <h3>Profil</h3>
                <span class="material-symbols-outlined">id_card</span>
            </div>
            <div class="account-card-list">
                <ul>
                    <li><a href="index.php?action=displayProfile&id=<?= $_SESSION['idUser'] ?>" title="voir le profil tel qu'il apparaît en public">
                        <span class="material-symbols-outlined">tv_signin</span>
                        <br>Visualiser</a>
                    </li>
                    <li>
                        <a href="index.php?action=showUpdateProfileForm" title="Compléter ou modifier les informations du profil">    
                        <span class="material-symbols-outlined">person_edit</span>
                        <br>Compléter</a>
                    </li>
                    <li>
                        <a href="index.php?action=disconnectUser" title="Se déconnecter">    
                        <span class="material-symbols-outlined">logout</span>
                        <br>Se déconnecter</a>
                    </li>

                </ul>
            </div>          
        </div>
        <div class="account-card">
            <div class="account-card-title">
                <h3>Newelles</h3>
                <span class="material-symbols-outlined">batch_prediction</span>
            </div>
            <div class="account-card-list">
                <ul>
                    <li><a href="index.php?action=manageNewelles" title="Gérer les Newelles, publier, modifier, supprimer.">
                        <span class="material-symbols-outlined">speech_to_text</span>
                        <br>Gérer</a>
                    </li>
                    <li>
                        <a href="index.php?action=addNewelle" title="Ajouter une Newelle">    
                        <span class="material-symbols-outlined">list_alt_add</span>
                        <br>Ajouter</a>
                    </li>
                </ul>
            </div>          
        </div>
        <div class="account-card">
            <div class="account-card-title">
                <h3>Feedbacks</h3>
                <span class="material-symbols-outlined">reviews</span>
            </div>
            <div class="account-card-list">
                <ul>
                    <li><a href="index.php?action=displayFeedbacks" title="Voir les commentaires et les coups de coeur">
                        <span class="material-symbols-outlined">visibility</span>
                        <br>Visualiser</a>
                    </li>
                    <li>
                        <span class="material-symbols-outlined">bookmark_heart</span>
                        <br>"200" coups de cœur 
                    </li>
                </ul>
            </div>          
        </div>
    </nav>

</div>
