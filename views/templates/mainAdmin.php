<?php 
/**
 * Ce fichier est le template admin principal qui "contient" ce qui aura été généré par les autres vues.  
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
</head>

<body>

    <header>
        <div class="header-admin">
            <div class="logo">
                <a href="index.php" title="retour à l'accueil"><img src="img/interface/newel_logo.png" alt="logo du site Newelles"/></a>
            </div>
            <div class="title">
                    <p>Newelles</p>
            </div>
            <div class="nav">
                <nav>
                    <a class="material-symbols-outlined" href="index.php?action=disconnectAdmin" 
                    <?php 
                    if (isset($_SESSION['admin'])){
                        echo "title=\"Compte utilisateur\"> admin_panel_settings";
                    } else {
                       echo "title=\"Se connecter ou créer un compte\"> login";
                    } ?>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="admin">
        <div class="main-container">
            <div class="left-bar">
                <a href="index.php?action=displayAdmin"><h1>Page admin</h1></a>
                <nav>
                    <ul>
                        <li><a href ="index.php?action=adminNewellers" title="Gestion des Newellers">Newellers</a></li>
                        <li><a href ="index.php?action=adminNewelles" title="Gestion des Newelles">Newelles</a></li>
                        <li><a href ="index.php?action=adminFeedbacks" title="Gestion des Feedbacks">Feedbacks</a></li>
                        <li><a href ="index.php?action=adminStats" title="Gestion des statistiques">Stats</a></li>
                    </ul>
                </nav>
            </div>
            <div class="content">
                <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
            </div>
        </div>
    </main>
    
    <footer>
        <p>Administrateur - Copyright © Newelles 2024 - Neobook -</p>
    </footer>

</body>
</html>
