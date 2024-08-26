<?php 
/**
 * Contrôleur du moteur de recherche
 */
 
class SearchController
{  
    /**
     * Affichage du résultat de la recherche.
     * @return void
     */
    public function displaySearchResult() : void 
    {
        $keyword = Utils::request("keyword");
        if(is_null($keyword))
        {
            $keyword="";
        }
        $searchManager = new SearchManager();
        $newelles = $searchManager->extractSearchResult($keyword);

        if (empty($newelles)) 
        {
           throw new exception("Désolé, votre recherche n'a retourné aucun résultat. Essayez avec un autre mot clé.");
        }

        $view = new View("Résultat de la recherche");
        $view->render("searchResults", ['newelles' => $newelles]);
    }
}