<?php 
/**
 * Contrôleur de la partie user.
 */
 
class UserController 
{  
    /**
     * Méthode pour créer un utilisateur
     *
     * @return void
     */    
    public function createUser() : void 
    {
        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $email = Utils::request("email");
        $rawPassword = Utils::request("password");
        $confirmPassword = Utils::request("confirm_password");
        $name = Utils::request("name");
        $firstName = Utils::request("firstName");
        $stageName = Utils::request("stageName");
        $bio = null;
        $is_adm = false;
        $usr_img = null;        

        // On vérifie que les données sont valides.
        if (empty($email) || empty($rawPassword)  || empty($name) || empty($firstName) || empty($stageName)) {
            throw new Exception("Tous les champs sont obligatoires.");
        } else if ($rawPassword !== $confirmPassword)
        {
            throw new Exception("Les mots de passe ne correspondent pas");
        }

        
        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($email);
        if ($user) {
            throw new Exception("Un compte existe déjà avec cet e-mail.");
        }

        //on fait le hash pour le mot de passe
        $password = password_hash($rawPassword, PASSWORD_BCRYPT);

        // On crée l'objet user
        $user = new User([
            'id' => $id, // Si l'id vaut -1, l'utilisateur sera ajouté. Sinon, il sera modifié.
            'name' => $name,
            'first_name' => $firstName,
            'stage_name' => $stageName,
            'email' => $email,
            'password' => $password
        ]);

        // On ajoute le user.
        $userManager = new UserManager();
        $userManager->addUser($user);

        // On redirige vers la page de connexion
        Utils::redirect("userAccount");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser() : void 
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On redirige vers la page d'accueil.
        Utils::redirect("home");
    }

    /**
     * Affichage du formulaire de création de compte
     *
     * @return void
     */
    public function displayCreateAccountForm($email, $password) : void
    {
        
        // On récupère les données du formulaire.
        $userDatas = [        
            'email' => $email,
            'password' => $password,
        ];


        $view = new View("CreateAccount");
        $view->render("createAccountForm", ['userDatas' => $userDatas]);
    }

    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm() : void 
    {
        $view = new View("Connexion");
        $view->render("connectionForm");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser() : void 
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
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($email);
        if (!$user) {
            $this->displayCreateAccountForm($email, $password);
            die;
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            throw new Exception("Le mot de passe est incorrect");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page compte utilisateur.
        Utils::redirect("userAccount");
    }


    /**
     * Affiche le compte user.
     * @return void
     */
    public function displayUserAccount() : void
    {
        // On vérifie que l'utilisateur est connecté.
        utils::checkIfUserIsConnected();
        $userId = $_SESSION['idUser'];
   
        $feedbackManager = new FeedbackManager();
        $thumbupsCount = $feedbackManager->countThumbupsByUserId($userId);

        // On affiche la page compte user.
        $view = new View("userAccount");
        $view->render("userAccount", ['thumbupsCount' => $thumbupsCount]);
    }
  
    /**
     * Affichage de la page de gestion des newelles.
     * @return void
     */
    public function manageNewelles() : void 
    {
        utils::checkIfUserIsConnected();

        $userId = $_SESSION['idUser'];
        // On récupère la newelle associée.
        $newelleManager = new NewelleManager();
        $newellesUser = $newelleManager->getAllNewellesByUser($userId);

        // On affiche la page de gestion des newelles.
        $view = new View("Gestion des Newelles");
        $view->render("manageNewelles", [
            'newellesUser' => $newellesUser
        ]);
    }

 
    /**
     * Méthode d'affichage du formulaire de mise à jour du profil utilisateur
     *
     * @return void
     */
    public function showUpdateProfileForm() : void
    {
        utils::checkIfUserIsConnected();

        // On récupère l'id du user.
        $idUser = $_SESSION['idUser'];

        // On récupère le profil
        $userManager = new userManager();
        $profile = $userManager->getUserById($idUser);

        // On affiche la page de modification de la newelle.
        $view = new View("Modification du profil");
        $view->render("updateProfileForm", ['profile' => $profile]);         
    }

    /**
     * Métode de mise à jour du profil utilisateur 
     *
     * @return void
     */
    public function updateProfile() : void
    {
       
        utils::checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $email = Utils::request("email");
        $name = Utils::request("name");
        $firstName = Utils::request("firstName");
        $stageName = Utils::request("stageName");
        $bio = Utils::request("bio");
        $rawUsrImg = $_FILES['usrImg'];
        $idAdmin = 0;
        $idUser = utils::request("id");

        // On vérifie que les données sont valides.
        if (empty($email) || empty($name) || empty($firstName) || empty($stageName)) {
            throw new Exception("Tous les champs sont obligatoires. 5");
        }

        if (!isset($rawUsrImg) && $rawUsrImg['error']) 
        {
            throw new Exception("Une erreur est survenue avec le fichier image");
        }

        if ($rawUsrImg['size'] > 2000000) 
        {
            throw new Exception("L'image est trop lourde (supérieure à 2Mo)");
        }

        // On vérifie si l'image a été mise à jour, si ce n'est pas le cas on assigne la valeur existante à la variable $UsrImg
        if (empty($rawUsrImg['name'])){
            $usrImg = utils::request("currentImg");
        } else {
            // On vérifie que l'extension de l'image est valide.
            $fileInfo = pathinfo($rawUsrImg['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($extension, $allowedExtensions))
            {
                throw new Exception("L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisé");
            }

            //On vérifie si le dossier uploads est manquant
            $path = 'img/users/';
            if (!is_dir($path)) {
                throw new Exception("Erreur lors de l'enregistrement de l'image, dossier cible manquant");
            }
            move_uploaded_file($rawUsrImg['tmp_name'], $path . basename($rawUsrImg['name']));
            $usrImg = $path . basename($rawUsrImg['name']);        
        }

        // On crée l'objet User.
        $profile = new User([
            'email' => $email,
            'name' => $name,
            'first_name' => $firstName,
            'stage_name' => $stageName,
            'bio' => $bio,
            'usr_img' => $usrImg,
            'id' => $idUser,
        ]);
        // On ajoute la newelle.
        $userManager = new UserManager();
        $userManager->UpdateUser($profile);

        // On redirige vers la page du compte utilisateur.
        if ($_SESSION['admin']){
            Utils::redirect("adminNewellers");
        } else {
        Utils::redirect("userAccount"); 
        }
    }

    public function displayProfile() : void
    {
        //on récupère l'ID du profile       
        $profileId = utils::request("id", -1);

        //on récpère les données pour l'objet user
        $userManager = new UserManager();
        $profile = $userManager->getUserById($profileId);

        if (!$profile) {
            throw new Exception("Le profile demandé n'existe pas.");
        }

        //on récupère les newelles du profil sélectionné
        $newelleManager = new NewelleManager();
        $profileNewelles = $newelleManager->getAllNewellesByUser($profileId);
        $view = new View($profile->getStageName());
        $view->render("displayProfile", ['profile' => $profile, 'profileNewelles' => $profileNewelles]);
    }

    public function displayFeedbacks():void
    {
        utils::checkIfUserIsConnected();
        $id = $_SESSION['idUser'];
        // on récupère les feedbacks groupés par newelle et filtrés par utilisateur
        $feedbackManager = new FeedbackManager();
        $userFeedbacks = $feedbackManager->getFeedbacksByUserId($id);
        $view = new View("Affichage des feedbacks");
        $view->render("displayFeedbacks", ['userFeedbacks' => $userFeedbacks]);
    }
}