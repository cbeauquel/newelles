<?php

/**
 * Classe qui gère les newelles.
 */
class NewelleManager extends AbstractEntityManager 
{
    /**
     * Récupère toutes les newelles.
     * @return array : un tableau d'objets Newelle.
     */
    public function getAllNewelles() : array
    {
        $sql = "SELECT a.* , b. `stage_name`
        FROM newelle a
        LEFT JOIN `users` b on a. `id_user` = b. `id`
        GROUP BY a. `id`
        ";
        $result = $this->db->query($sql);
        $newelles = [];

        while ($newelle = $result->fetch()) {
            $newelles[] = new Newelle($newelle);
        }
        return $newelles;
    }
    
    /**
     * Récupère un Newelle par son id.
     * @param int $id : l'id de l'newelle.
     * @return Newelle|null : un objet Newelle ou null si la Newelle n'existe pas.
     */
    public function getNewelleById(int $id) : ?Newelle
    {
        $sql = "SELECT a.* , b. `stage_name`
        FROM newelle a
        LEFT JOIN `users` b on a. `id_user` = b. `id`
        WHERE a. id = :id";

        $result = $this->db->query($sql, ['id' => $id]);
        $newelle = $result->fetch();
        if ($newelle) {
            return new Newelle($newelle);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un newelle.
     * On sait si la newelle est un nouvel newelle car son id sera -1.
     * @param Newelle $newelle : la newelle à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateNewelle(Newelle $newelle) : void 
    {
        if ($newelle->getId() == -1) {
            $this->addNewelle($newelle);
        } else {
            $this->updateNewelle($newelle);
        }
    }

    /**
     * Ajoute une newelle.
     * @param Newelle $newelle : la newelle à ajouter.
     * @return void
     */
    public function addNewelle(Newelle $newelle) : void
    {
        $sql = "INSERT INTO newelle (id_user, date_creation, date_update, title, audio, content, nwl_img, genre, duree, taille) VALUES (:id_user, NOW(), NOW(), :title, :audio, :content, :nwl_img, :genre, :duree, :taille)";
        $this->db->query($sql, [
            'id_user' => $newelle->getIdUser(),
            'title' => $newelle->getTitle(),
            'audio' => $newelle->getAudio(),
            'content' => $newelle->getContent(),
            'nwl_img' => $newelle->getNwlImg(),
            'genre' => $genre->getGenre(),
            'duree' => $duree->getDuree(),
            'taille' => $taille->getTaille()
        ]);
    }

    /**
     * Modifie une newelle.
     * @param Newelle $newelle : la newelle à modifier.
     * @return void
     */
    public function updateNewelle(Newelle $newelle) : void
    {
        $sql = "UPDATE newelle SET title = :title, audio = :audio, content = :content, date_update = NOW(), nwl_img = :nwlimg, genre = :genre, duree = :duree, taille = :taille WHERE id = :id";
        $this->db->query($sql, [
            'title' => $newelle->getTitle(),
            'audio' => $newelle->getAudio(),
            'content' => $newelle->getContent(),
            'nwl_img' => $newelle->getNwlImg(),
            'genre' => $genre->getGenre(),
            'duree' => $duree->getDuree(),
            'taille' => $taille->getTaille(),
            'id' => $newelle->getId()
        ]);
    }

    /**
     * Supprime une newelle.
     * @param int $id : l'id de la newelle à supprimer.
     * @return void
     */
    public function deleteNewelle(int $id) : void
    {
        $sql = "DELETE FROM newelle WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
}