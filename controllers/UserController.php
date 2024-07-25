<?php 
/**
 * Contrôleur de la partie user.
 */
 
class UserController 
{
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
        $name = Utils::request("name");
        $firstName = Utils::request("firstName");
        $stageName = Utils::request("stageName");
        $bio = null;
        $is_adm = false;
        $usr_img = null;        

        // On vérifie que les données sont valides.
        if (empty($email) || empty($rawPassword)  || empty($name) || empty($firstName) || empty($stageName)) {
            throw new Exception("Tous les champs sont obligatoires.");
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
     * Affichage du formulaire d'ajout d'un article.
     * @return void
     */
    public function showUpdateArticleForm() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère l'id de l'article s'il existe.
        $id = Utils::request("id", -1);

        // On récupère l'article associé.
        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($id);

        // Si l'article n'existe pas, on en crée un vide. 
        if (!$article) {
            $article = new Article();
        }

        // On affiche la page de modification de l'article.
        $view = new View("Edition d'un article");
        $view->render("updateArticleForm", [
            'article' => $article
        ]);
    }

    /**
     * Ajout et modification d'un article. 
     * On sait si un article est ajouté car l'id vaut -1.
     * @return void
     */
    public function updateArticle() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $title = Utils::request("title");
        $content = Utils::request("content");

        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 2");
        }

        // On crée l'objet Article.
        $article = new Article([
            'id' => $id, // Si l'id vaut -1, l'article sera ajouté. Sinon, il sera modifié.
            'title' => $title,
            'content' => $content,
            'id_user' => $_SESSION['idUser']
        ]);

        // On ajoute l'article.
        $articleManager = new ArticleManager();
        $articleManager->addOrUpdateArticle($article);

        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }


    /**
     * Suppression d'un article.
     * @return void
     */
    public function deleteArticle() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime l'article.
        $articleManager = new ArticleManager();
        $articleManager->deleteArticle($id);
       
        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }
}