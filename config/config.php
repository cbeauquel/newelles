<?php
    
    // on démarre une session. 
    session_start();

    //on saisi ici ce qui sert à configurer le site 

    define('TEMPLATE_VIEW_PATH', './views/templates/'); // Le chemin vers les templates de vues.
    define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php'); // Le chemin vers le template principal.
    define('ADMIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'mainAdmin.php'); // Le chemin vers le template principal admin.

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'newelles');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('H_CAPTCHA', 'ES_3cec497b1417413795ebc5b0cec3932b');
