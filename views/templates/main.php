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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@0..1" />
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/dcvenw2y0g3iby40929n5t6szarz1lw6is0467eq3u0gehmm/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
    tinymce.init({
        selector: 'textarea#rtf',
        plugins: 'anchor autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags inlinecss markdown',
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
    <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
</head>

<body>

    <header>
        <div class="header">
            <div class="logo">
                <a href="index.php" title="retour à l'accueil"><img src="img/interface/newel_logo.png" alt="logo du site Newelles"/></a>
            </div>
            <div class="title">
                    <h1>Newelles</h1>
            </div>
            <div class="nav">
                <nav>
                    <a class="material-symbols-outlined" 
                    <?php 
                    if (isset($_SESSION['user'])){
                        echo "href=\"index.php?action=userAccount\" title=\"Compte utilisateur\"> account_circle";
                    } elseif (isset($_SESSION['admin'])) {
                       echo "href=\"index.php?action=displayAdmin\"title=\Compte Administrateur\">admin_panel_settings";
                    } else {
                       echo "href=\"index.php?action=userAccount\" title=\"Se connecter ou créer un compte\">login";
                    }?>
                    </a>
                </nav>
            </div>
        </div>
        <div class="signature">
            <p>Écoutez, lisez, partagez des histoires originales !</p>
        </div>
    </header>

    <main>    
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>
    
    <footer>
        <a href="index.php?action=connectionFormAdmin">À propos&nbsp;</a>
        <p>Copyright © Newelles 2024 - Neobook -</p>
    </footer>

</body>
</html>
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