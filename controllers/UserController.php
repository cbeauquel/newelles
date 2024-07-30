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
        $this->checkIfUserIsConnected();

        // On affiche la page compte user.
        $view = new View("userAccount");
        $view->render("userAccount");
    }
  
    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected() : void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Utils::redirect("connectionForm");
        }
    }

    /**
     * Affichage de la page de gestion des newelles.
     * @return void
     */
    public function manageNewelles() : void 
    {
        $this->checkIfUserIsConnected();

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
     * Affichage du formulaire d'ajout d'une newelle.
     * @return void
     */
    public function showUpdateNewelleForm() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère l'id de la newelle s'il existe.
        $id = Utils::request("id", -1);

        // On récupère la newelle associée.
        $newelleManager = new NewelleManager();
        $newelle = $newelleManager->getNewelleById($id);

        // Si la newelle n'existe pas, on en crée une vide. 
        if (!$newelle) {
            $newelle = new Newelle();
        }

        // On affiche la page de modification de la newelle.
        $view = new View("Modification d'une newelle");
        $view->render("updateNewelleForm", [
            'newelle' => $newelle
        ]);
    }

    /**
     * Ajout et modification d'une newelle. 
     * On sait si une newelle est ajoutée car l'id vaut -1.
     * @return void
     */
    public function updateNewelle() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $title = Utils::request("title");
        $genre = Utils::request("genre");
        $taille = Utils::request("taille");
        $duree = Utils::request("duree");
        $content = Utils::request("content");

        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 3");
        }
        
        if (!isset($_FILES['nwlImg']) && $_FILES['nwlImg']['error']) 
        {
            throw new Exception("Une erreur est survenue avec le fichier image");
        }

        if ($_FILES['nwlImg']['size'] > 2000000) 
        {
            throw new Exception("L'image est trop lourde (supérieure à 2Mo)");
        }

        // On vérifie si l'image a été mise à jour, si ce n'est pas le cas on assigne la valeur existante à la variable $nwlImg
        if ($id != -1 && empty($_FILES['nwlImg']['name'])){
            $nwlImg = utils::request("currentImg");
        } else {
            // On vérifie que l'extension de l'image est valide.
            $fileInfo = pathinfo($_FILES['nwlImg']['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($extension, $allowedExtensions))
            {
                throw new Exception("L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisé");
            }

            //On vérifie si le dossier uploads est manquant
            $path = 'img/content/';
            if (!is_dir($path)) {
                throw new Exception("Erreur lors de l'enregistrement de l'image, dossier cible manquant");
            }
            move_uploaded_file($_FILES['nwlImg']['tmp_name'], $path . basename($_FILES['nwlImg']['name']));
            $nwlImg = $path . basename($_FILES['nwlImg']['name']);        
        }

        //on vérifie les données audio 
        if (!isset($_FILES['audio']) && $_FILES['audio']['error']) 
        {
            throw new Exception("Une erreur est survenue avec le fichier audio");
        }

        if ($_FILES['audio']['size'] > 8000000) 
        {
            throw new Exception("La piste audio est trop lourde (supérieure à 8Mo)");
        }

        if ($id != -1 && empty($_FILES['audio']['name'])){
            $nwlImg = utils::request("currentAudio");
        } else {
            // On vérifie que l'extension de l'image est valide.
            $fileInfo = pathinfo($_FILES['audio']['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['mp3', 'wmv'];
            if (!in_array($extension, $allowedExtensions))
            {
                throw new Exception("L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée");
            }

            //On vérifie si le dossier uploads est manquant
            $path = 'audio/';
            if (!is_dir($path)) {
                throw new Exception("Erreur lors de l'enregistrement du son, dossier cible manquant");
            }
            move_uploaded_file($_FILES['audio']['tmp_name'], $path . basename($_FILES['audio']['name']));
            $audio = $path . basename($_FILES['audio']['name']);        
        }



        //on calcule la taille du texte envoyée (variable $content)
        $taille = str_word_count($content);

        // on s 'assure que le champs "durée" est bien un entier 
        $duree = preg_replace('/\D/', '', $duree);

        // On crée l'objet Newelle.
        $newelle = new Newelle([
            'id' => $id, // Si l'id vaut -1, la newelle sera ajoutée. Sinon, elle sera modifiée.
            'title' => $title,
            'content' => $content,
            'genre' => $genre,
            'taille' => $taille,
            'duree' => $duree,
            'id_user' => $_SESSION['idUser'],
            'nwl_img' => $nwlImg,
            'audio' => $audio
        ]);

        // On ajoute la newelle.
        $newelleManager = new NewelleManager();
        $newelleManager->addOrUpdateNewelle($newelle);

        // On redirige vers la page du compte utilisateur.
        Utils::redirect("detail&id=" . $newelle->getId());

    }


    /**
     * Suppression d'une newelle.
     * @return void
     */
    public function deleteNewelle() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime la newelle.
        $newelleManager = new NewelleManager();
        $newelleManager->deleteNewelle($id);
       
        // On redirige vers la page d'administration.
        Utils::redirect("userAccount");
    }
}