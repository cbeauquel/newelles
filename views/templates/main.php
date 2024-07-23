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
    <title>Newelles</title>
    <link rel="stylesheet" href="./styles/MainStyle.css">
</head>

<body>
    <header>
        <nav>
            <a href="index.php">Newelles</a>
            <?php 
                // Si on est connecté, on affiche le bouton de déconnexion, sinon, on affiche le bouton de connexion : 
                if (isset($_SESSION['user'])) {
                    echo '<a href="index.php?action=disconnectUser"><img src="img/deconnection.png" alt="se déconnecter"/></a>';
                } else {
                    echo '<a href="index.php?action=connection"><img src="img/connection.png" alt="se connecter"/></a>';
                }
                ?>
        </nav>
        <a href="index.php">
            <h1>Newelles</h1>
        </a>
    </header>

    <main>    
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>
    
    <footer>
        <a href="index.php?action=apropos">À propos</a>
        <p>Copyright © Newelles 2024 - Neobook -</p>
    </footer>

</body>
</html>