<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');
$MonitoringManager = new MonitoringManager();
$compteur = $MonitoringManager->collectStats();

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $newelleController = new NewelleController();
            $newelleController->showHome();
            break;
        
        case 'displayAllNewelles':
            $newelleController = new NewelleController();
            $newelleController->displayAllNewelles();
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
            $newelleController = new NewelleController();
            $newelleController->showUpdateNewelleForm();
            break;

        case 'updateNewelle':
            $newelleController = new NewelleController();
            $newelleController->updateNewelle();
            break;

        case 'delete':
            $newelleController = new NewelleController();
            $newelleController->deleteNewelle();
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

        case 'displayFeedbacks':
            $userController = new UserController();
            $userController->displayFeedbacks();
            break;

        case 'disconnectAdmin':
            $adminController = new AdminController();
            $adminController->disconnectAdmin();
            break;

        case 'connectionFormAdmin':
            $adminController = new AdminController();
            $adminController->displayConnectionFormAdmin();
            break;
    
        case 'connectAdmin':
            $adminController = new AdminController();
            $adminController->connectAdmin();
            break;
        
        case 'displayAdmin':
            $adminController = new AdminController();
            $adminController->displayAdmin();
            break;
        
        case 'adminNewellers':
            $adminController = new AdminController();
            $adminController->adminNewellers();
            break;
        
        case 'showApropos':
            $newelleController = new NewelleController();
            $newelleController->showApropos();
            break;


        case 'adminUpdateProfileForm':
            $adminController = new AdminController();
            $adminController->adminUpdateProfileForm();
            break;

        case 'adminProfileDelete':
            $adminController = new AdminController();
            $adminController->adminProfileDelete();
            break;
        
        case 'adminNewelles':
            $adminController = new AdminController();
            $adminController->adminNewelles();
            break;

        case 'adminUpdateNewelleForm':
            $adminController = new AdminController();
            $adminController->adminUpdateNewelleForm();
            break;
     
        case 'adminFeedbacks':
            $adminController = new AdminController();
            $adminController->adminFeedbacks();
            break;

        case 'adminFeedbackDelete':
            $adminController = new AdminController();
            $adminController->adminFeedbackDelete();
        break;
    
        case 'adminStats':
            $adminController = new AdminController();
            $adminController->adminStats();
            break;
            
        case 'search':
            $searchController = new SearchController();
            $searchController->displaySearchResult();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
