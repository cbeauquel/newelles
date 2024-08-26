<?php 
/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./styles/MainStyle.css">
    <link rel="stylesheet" href="./styles/TabletStyle.css">
    <link rel="stylesheet" href="./styles/MobileStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@0..1" >
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/dcvenw2y0g3iby40929n5t6szarz1lw6is0467eq3u0gehmm/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
    tinymce.init({
        selector: 'textarea#rtf',
        plugins: 'anchor autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount  linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
    });
    </script>
    <script src='https://js.hcaptcha.com/1/api.js' async defer></script>
</head>

<body>

    <header class="header" aria-label="Entête du site">
        <a href="index.php" class="title" aria-label="Retour à l'accueil" title="retour à l'accueil"><p>Newelles</p></a>
        <div class="search">
            <form method="post" action="index.php?action=search">
                <label class="material-symbols-outlined" for="keyword">search</label>
                <input aria-label="Find a Newelle" type="text" name="keyword" id="keyword"  placeholder="recherchez une newelle ou un neweller !">
                <input type="submit" value="Rechercher" id="submit">
                <button class="material-symbols-outlined" type="submit">search</button>
            </form>
        </div>
        <nav class="nav" aria-label="Navigation, connexion au compte utilisateur">
                <a
                <?php 
                if (isset($_SESSION['user'])){
                    echo "href=\"index.php?action=userAccount\" title=\"Compte utilisateur\"><span class=\"material-symbols-outlined\">account_circle</span><br>Compte utilisateur";
                } elseif (isset($_SESSION['admin'])) {
                    echo "href=\"index.php?action=displayAdmin\" title=\"Compte Administrateur\"><span class=\"material-symbols-outlined\">admin_panel_settings</span><br>Administration";
                } else {
                    echo "href=\"index.php?action=userAccount\" title=\"Se connecter ou créer un compte\"><span class=\"material-symbols-outlined\">login</span><br>Se connecter";
                }?>
                </a>
        </nav>
    </header>

    <main aria-label="contenu de la page">    
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>
    <footer>
        <nav aria-label="navigation de pied de page">
            <a href="index.php?action=showApropos" title="à propos du site Newelles">À propos&nbsp;</a>
             - Copyright © Newelles 2024 - Neobook - 
             <a class="material-symbols-outlined" href="index.php?action=connectionFormAdmin" title="administration">admin_panel_settings</a>
        </nav>
    </footer>
    <script>
        var audio = document.getElementById('audio');
        var playPauseButton = document.getElementById('playPauseButton');

        playPauseButton.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
                playPauseButton.textContent = 'Pause';
            } else {
                audio.pause();
                playPauseButton.textContent = 'play_circle';
            }
        });

        audio.addEventListener('ended', function() {
            playPauseButton.textContent = 'play_circle';
        });
    </script>
</body>
</html>