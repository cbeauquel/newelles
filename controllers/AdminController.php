<?php 
/**
 * Contrôleur de la partie admin
 */
 
class AdminController extends UserController
{  
    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionFormAdmin() : void 
    {
        $view = new View("Connexion de l'administrateur");
        $view->render("connectionFormAdmin");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectAdmin() : void 
    {
        global $email, $password;
        // On récupère les données du formulaire.
        $email = Utils::request("email");
        $password = Utils::request("password");
        // On vérifie que les données sont valides.
        if (empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. 1");
        }

        // On vérifie que l'utilisateur existe.
        $adminManager = new AdminManager();
        $admin = $adminManager->getAdminByLogin($email);


        if (!$admin) {
            throw new Exception("Il n'y a pas d'administrateur enregistré avec les données saisies");
        }

        $isAdmin = $admin->getIsAdmin();

        if (!$isAdmin) {
            throw new Exception("Il n'y a pas de compte administrateur avec cet e-mail");
         }


        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $admin->getPassword())) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            throw new Exception("Le mot de passe est incorrect");
        }
        // On connecte l'utilisateur.
        $_SESSION['admin'] = $admin;
        $_SESSION['idadmin'] = $admin->getId();
        
        // On redirige vers la page compte utilisateur.
        Utils::redirect("displayAdmin");
    }
        /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectAdmin() : void 
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['admin']);

        // On redirige vers la page d'accueil.
        Utils::redirect("home");
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfAdminIsConnected() : void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['admin'])) {
            Utils::redirect("connectionFormAdmin");
        }
    }

    /**
     * Affiche l'Admin.
     * @return void
     */
    public function displayAdmin() : void
    {
        // On vérifie que l'admin est connecté.
        $this->checkIfAdminIsConnected();

        // On affiche la page compte user.
        $view = new View("Page d'administration");
        $view->render("admin");
    }
}