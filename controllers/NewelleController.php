<?php 

class NewelleController 
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome() : void
    {
        $newelleManager = new NewelleManager();
        $newelles = $newelleManager->getSixNewelles();

        $userManager = new UserManager();
        $profiles = $userManager->getAllProfiles();
        $view = new View("Accueil");
        $view->render("home", ['newelles' => $newelles, 'profiles' => $profiles]);
    }

    public function displayAllNewelles()
    {
        $newelleManager = new NewelleManager();
        $newelles = $newelleManager->getAllNewelles();

        $view = new View("Toutes les Newelles");
        $view->render("displayAllNewelles", ['newelles' => $newelles]);

    }

    /**
     * Affiche le détail d'une newelle.
     * @return void
     */
    public function showNewelle() : void
    {
        // Récupération de l'id de la newelle demandé.
        $id = Utils::request("id", -1);

        $newelleManager = new NewelleManager();
        $newelle = $newelleManager->getNewelleById($id);
        
        if (!$newelle) {
            throw new Exception("La newelle demandé n'existe pas.");
        }

        $feedbackManager = new FeedbackManager();
        $feedbacks = $feedbackManager->getFeedbacksByNewelleId($id);
        $view = new View($newelle->getTitle());
        $view->render("detailNewelle", ['newelle' => $newelle, 'feedbacks' => $feedbacks]);
    }

    /**
     * Affiche le formulaire d'ajout d'une newelle.
     * @return void
     */
    public function addNewelle() : void
    {
        $this->showUpdateNewelleForm();
    }

   /**
     * Affichage du formulaire d'ajout d'une newelle.
     * @return void
     */
    public function showUpdateNewelleForm() : void 
    {
        utils::checkIfUserIsConnected();

        // On récupère l'id de la newelle s'il existe.
        $id = Utils::request("id", -1);


        // On récupère la newelle associée.
        $newelleManager = new NewelleManager();
        $newelle = $newelleManager->getNewelleById($id);
        if ($id != -1){
            $idUser = $newelle->getidUser();
            //on vérifie que le User connecté est bien l'auteur de la Newelle
            if ($idUser != $_SESSION['idUser']){
                throw new Exception("Vous ne pouvez pas modifier une Newelle publié par un autre Neweller");
            }
        }
 
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
        utils::checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $idUser =  Utils::request("idUser");
        $title = Utils::request("title");
        $genre = Utils::request("genre");
        $duree = Utils::request("duree");
        $content = Utils::request("content");
        $nwlImg = $_FILES['nwlImg'];
        $audio = $_FILES['audio'];


        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 3");
        }
        
        if (!isset($nwlImg) && $nwlImg['error']) 
        {
            throw new Exception("Une erreur est survenue avec le fichier image");
        }

        if ($nwlImg['size'] > 2000000) 
        {
            throw new Exception("L'image est trop lourde (supérieure à 2Mo)");
        }

        // On vérifie si l'image a été mise à jour, si ce n'est pas le cas on assigne la valeur existante à la variable $nwlImg
        if ($id != -1 && empty($nwlImg['name'])){
            $nwlImg = utils::request("currentImg");
        } else {
            // On vérifie que l'extension de l'image est valide.
            $fileInfo = pathinfo($nwlImg['name']);
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
            move_uploaded_file($nwlImg['tmp_name'], $path . basename($nwlImg['name']));
            $nwlImg = $path . basename($nwlImg['name']);        
        }
        var_dump($id);

        //on vérifie les données audio 
        if (!isset($audio) && $audio['error']) 
        {
            throw new Exception("Une erreur est survenue avec le fichier audio");
        }

        if ($audio['size'] > 8000000) 
        {
            throw new Exception("La piste audio est trop lourde (supérieure à 8Mo)");
        }

        if ($id != -1 && empty($audio['name'])){
            $audio = utils::request("currentAudio");
        } elseif ($id === "-1" && empty($audio['name'])){
            $audio = null;
        } else {
            // On vérifie que l'extension de l'image est valide.
            $fileInfo = pathinfo($audio['name']);
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
            move_uploaded_file($audio['tmp_name'], $path . basename($audio['name']));
            $audio = $path . basename($audio['name']);        
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
            'id_user' => $idUser,
            'nwl_img' => $nwlImg,
            'audio' => $audio,
        ]);

        // On ajoute la newelle.
        $newelleManager = new NewelleManager();
        $newelleManager->addOrUpdateNewelle($newelle);

        // On redirige vers la page de la newelle.
        if ($_SESSION['admin']){
            Utils::redirect("adminNewelles");
        } elseif ($id==="-1"){
            Utils::redirect("home");
        } else { 
            Utils::redirect("detail&id=" . $newelle->getId());
        }    
    }

    /**
     * Suppression d'une newelle.
     * @return void
     */
    public function deleteNewelle() : void
    {
        utils::checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime la newelle.
        $newelleManager = new NewelleManager();
        $newelleManager->deleteNewelle($id);
       
        // On redirige vers la page d'administration.
        if ($_SESSION['admin']){
            Utils::redirect("adminNewelles");
        } else {
        Utils::redirect("userAccount");
        }
    }
    
    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos() {
        $view = new View("A propos");
        $view->render("apropos");
    }
}