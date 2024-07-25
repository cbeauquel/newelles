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
        $newelles = $newelleManager->getAllNewelles();

        $view = new View("Accueil");
        $view->render("home", ['newelles' => $newelles]);
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

        // $commentManager = new CommentManager();
        // $comments = $commentManager->getAllCommentsByNewelleId($id);

        $view = new View($newelle->getTitle());
        $view->render("detailNewelle", ['newelle' => $newelle]);
    }

    /**
     * Affiche le formulaire d'ajout d'une newelle.
     * @return void
     */
    public function addNewelle() : void
    {
        $view = new View("Ajouter une newelle");
        $view->render("addNewelle");
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