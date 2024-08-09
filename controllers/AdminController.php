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
        $_SESSION['idUser'] = $admin->getId();
        
        // On redirige vers la page compte utilisateur.
        Utils::redirect("adminNewelles");
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
        utils::checkIfUserIsConnected();

        $adminManager = new AdminManager();
        $adminNewelles = $adminManager->manageNewelles();

        // On affiche la page compte user.
        $view = new View("Page d'administration");
        $view->renderAdmin("displayAdmin");
    }

    /**
     * Méthode d'affichage du formulaire de mise à jour du profil utilisateur
     *
     * @return void
     */
    public function adminUpdateProfileForm() : void
    {
        $this->checkIfAdminIsConnected();

        $idUser = utils::request('id');

        // On récupère le profil
        $userManager = new userManager();
        $profile = $userManager->getUserById($idUser);

        // On affiche la page de modification de la newelle.
        $view = new View("Modification du profil");
        $view->renderAdmin("updateProfileForm", ['profile' => $profile]);         
    }

    public function adminNewellers(){

        $this->checkIfAdminIsConnected();

        $adminManager = new AdminManager();
        $newellers = $adminManager->manageNewellers();

        // On affiche la page 
        $view = new View("Gestion des Newellers");
        $view->renderAdmin("adminNewellers", ['newellers' => $newellers]);   
    }

    public function adminProfileDelete(){

        $this->checkIfAdminIsConnected();

        $id = Utils::request("id");

        $adminUser = new AdminUser();
        $adminUser->deleteUser($id);

        Utils::redirect("adminNewellers");
    }

    /**
     * Affichage du formulaire de modif d'une newelle 
     * @return void
     */
    public function adminUpdateNewelleForm() : void 
    {
        $this->checkIfAdminIsConnected();

        // On récupère l'id de la newelle s'il existe.
        $id = Utils::request("id");

        // On récupère la newelle associée.
        $newelleManager = new NewelleManager();
        $newelle = $newelleManager->getNewelleById($id);

        // On affiche la page de modification de la newelle.
        $view = new View("Modification d'une newelle");
        $view->renderAdmin("updateNewelleForm", ['newelle' => $newelle]);
    }

    public function adminNewelles(){
        $this->checkIfAdminIsConnected();

        $adminManager = new AdminManager();
        $adminNewelles = $adminManager->manageNewelles();

        // On affiche la page 
        $view = new View("Gestion des Newelles");
        $view->renderAdmin("adminNewelles", ['adminNewelles' => $adminNewelles]);   
    }

    public function adminFeedbacks(){
        $this->checkIfAdminIsConnected();

        $adminManager = new AdminManager();
        $adminFeedbacks = $adminManager->manageFeedbacks();

        // On affiche la page 
        $view = new View("Gestion des Feedbacks");
        $view->renderAdmin("adminFeedbacks", ['adminFeedbacks' => $adminFeedbacks]);         
    }

    public function adminFeedbackDelete(){

        $this->checkIfAdminIsConnected();

        $id = Utils::request("id");

        $feedbackManager = new FeedbackManager();
        $feedbackManager->deleteFeedback($id);

        Utils::redirect("adminFeedbacks");
    }

    public function adminStats(){
        $this->checkIfAdminIsConnected();
        $monitoringManager = new MonitoringManager();
        $stats = $monitoringManager->extractStats();

        $view = new View("Gestion des Stats");
        $view->renderAdmin("adminStats", ['stats' =>$stats]);         
    }
}