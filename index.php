<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $newelleController = new NewelleController();
            $newelleController->showHome();
            break;

        case 'detail':
            $newelleController = new NewelleController();
            $newelleController->showNewelle();
            break;

        case 'userAccount':
            $userController = new UserController();
            $userController->displayUserAccount();
            break;

        case 'manageNewelles':
            $userController = new UserController();
            $userController->manageNewelles();
            break;

        case 'connectionForm':
            $userController = new UserController();
            $userController->displayConnectionForm();
            break;

        case 'createAccountForm':
            $userController = new UserController();
            $userController->displayCreateAccountForm();
            break;

        case 'connectUser':
            $userController = new UserController();
            $userController->connectUser();
            break;

        case 'createUser':
            $userController = new UserController();
            $userController->createUser();
            break;

        case 'disconnectUser':
            $userController = new UserController();
            $userController->disconnectUser();
            break;

        case 'addNewelle':
            $newelleController = new NewelleController();
            $newelleController->addNewelle();
            break;

        case 'showUpdateNewelleForm':
            $userController = new UserController();
            $userController->showUpdateNewelleForm();
            break;

        case 'updateNewelle':
            $userController = new UserController();
            $userController->updateNewelle();
            break;

        case 'delete':
            $userController = new UserController();
            $userController->deleteNewelle();
            break;

        case 'showUpdateProfileForm':
            $userController = new UserController();
            $userController->showUpdateProfileForm();
            break;

        case 'updateProfile':
            $userController = new UserController();
            $userController->updateProfile();
            break;

        case 'displayProfile':
            $userController = new UserController();
            $userController->displayProfile();
            break;

        case 'addFeedback':
            $feedbackController = new FeedbackController();
            $feedbackController->addFeedback();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
