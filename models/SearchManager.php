<?php

/**
* Classe qui gère les méthodes du moteur de recherche
*/

class SearchManager extends AbstractEntityManager 
{
    public function extractSearchResult(string $keyword):?array
    {
        $sql = "SELECT *
        from newelle a
        left join users b on a. id_user = b. id
        where 
        match(a. title, a. genre, a. content) AGAINST(:keyword IN NATURAL LANGUAGE MODE)
        OR
        match(b. stage_name) AGAINST (:keyword IN NATURAL LANGUAGE MODE)";

        $result = $this->db->query($sql, ['keyword' => $keyword]);
        $newelles = [];

        while ($newelle = $result->fetch()) {
            $newelles[] = new Newelle($newelle);
        }
        return $newelles;
    }

}