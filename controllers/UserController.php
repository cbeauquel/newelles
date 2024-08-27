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
        if (empty($email) || empty($rawPassword)  || empty($name) || empty($firstName) || empty($stageName)) 
        {
            throw new Exception("Tous les champs sont obligatoires.");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception("Veuillez saisir une adresse e-mail valide");

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

        //on confirme la création du compte
        $view = new View("Succès");
        $redirect = "userAccount";
        $succesMessage ="Votre compte a bien été créé, vous pouvez vous connecter en cliquant sur le lien ci-dessous";
        $view->render("succesPage", ['redirect' => $redirect, 'succesMessage' => $succesMessage]);
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser() : void 
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On confirme la désinscription.
        $view = new View("Succès");
        $redirect = "home";
        $succesMessage ="Vous avez bien été déconnecté de votre compte, bonne journée !";
        $view->render("succesPage", ['redirect' => $redirect, 'succesMessage' => $succesMessage]);

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
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception("Veuillez saisir une adresse e-mail valide");
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
            throw new Exception("Le mot de passe est incorrect<br>
            <a class=\"button\" href=\"index.php?action=displayResetPassword\" title=\"Réinitialisation du mot de passe\">Réinitialiser le mot de passe</a>
            ");
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

        $userManager = new UserManager();      
        $displayUser = $userManager->getUserById($userId);

        // On affiche la page compte user.
        if (is_null($thumbupsCount)){
            $thumbupsCount = 0;
        }
        $view = new View("Compte utilisateur");
        $view->render("userAccount", ['thumbupsCount' => $thumbupsCount, 'displayUser' => $displayUser]);
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
        $userManager = new UserManager();
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

            //on renomme l'image pour éviter les erreurs dans les noms de fichier
             $UsrImgName = $idUser . '-' . strtr((mb_strtolower($stageName)), ' ', '-') . '.' . $extension;

            move_uploaded_file($rawUsrImg['tmp_name'], $path . basename($UsrImgName));
            $usrImg = $path . basename($UsrImgName);        
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

        //on confirme la création du compte
        $view = new View("Succès");
        if (isset($_SESSION['admin'])){
            $redirect = "adminNewellers";
        } else {
         $redirect = "userAccount"; 
        }
        $succesMessage ="Votre compte a bien été mis à jour";
        $view->render("succesPage", ['redirect' => $redirect, 'succesMessage' => $succesMessage]);
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
        $newelles = $newelleManager->getAllNewellesByUser($profileId);
        $view = new View($profile->getStageName());
        $view->render("displayProfile", ['profile' => $profile, 'newelles' => $newelles]);
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

    
    public function displayResetPassword()
    {
        $token = utils::request('token');

        $view = new View("Réinitialisation du Mot de passe");
        $view->render("resetPassword", ['token' => $token]);

    }

    /**
     * Méthode de réinitialisation du mot de passe
     *
     * @return void
     */
    public function resetPassword()
    {
        $email = Utils::request("email");
        $userManager = new UserManager();
        $userMail = $userManager->getUserByLogin($email);
  
        if ($userMail) {
            $id = $userMail->getId();

            //on génère un token unique
            $token = bin2hex(random_bytes(50));

            //on ajoute le token à la base de donnée
            $addToken = $userManager->addToken($id, $token);
        
            $resetLink = "https://newelles.fr/index.php?action=displayResetPassword&token=" . $token;

            // Envoyer l'email
            $to = $email;
            $subject = "Réinitialisation du password";
            $message = "Bonjour, suite à votre demande, trouvez ci-dessous le lien pour réinitialiser votre mot de passe : \n" . $resetLink;
            $headers = 'From: contact@neobook.fr' . "\r\n" .
                    'Reply-To: contact@neobook.fr' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
        
            // On confirme le succès de l'action
            $view = new View("Succès");
            $redirect = "userAccount";
            $succesMessage ="Un lien a été envoyé à votre boite e-mail pour réinitialiser votre mot de passe";
            $view->render("succesPage", ['redirect' => $redirect, 'succesMessage' => $succesMessage]);
    
        } else {
           throw new Exception("Aucun utilisateur avec cet e-mail ou adresse e-mail erronée");
        }
    }

    public function updatePassword()
    {
        $rawPassword = Utils::request("password");
        $confirmPassword = Utils::request("confirm_password");
        $rawToken = Utils::request('token');

        $userManager = new UserManager();
        $resetRequest = $userManager->getToken($rawToken);
        $id = $resetRequest['id'];
        if ($resetRequest && (strtotime($resetRequest['valid_time']) > strtotime('-1 hour')) && !is_null($id)) {

            // On vérifie que les données sont valides.
            if (empty($rawPassword)) {
                throw new Exception("Tous les champs sont obligatoires.");
            } else if ($rawPassword !== $confirmPassword)
            {
                throw new Exception("Les mots de passe ne correspondent pas");
            }
            //on fait le hash pour le mot de passe
            $password = password_hash($rawPassword, PASSWORD_BCRYPT);

            // on update le mot de passe
            $userManager = new UserManager();
            $userManager->updatePassword($id, $password);
        } else {
            echo "pas marcher";
        }

        // On confirme le succès de l'action
        $view = new View("Succès");
        $redirect = "userAccount";
        $succesMessage ="Votre mot de passe à bien été modifié. Vous pouvez vous connecter avec votre nouveau mot de passe";
        $view->render("succesPage", ['redirect' => $redirect, 'succesMessage' => $succesMessage]);
        
        
    }

}