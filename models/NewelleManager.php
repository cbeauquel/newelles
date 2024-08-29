<?php

/**
 * Classe qui gère les newelles.
 */
class NewelleManager extends AbstractEntityManager 
{
    /**
     * Récupère les 6 dernières nouvelles.
     * @return array : un tableau d'objets Newelle.
     */                 
    public function getSixNewelles() : array
    {
        $sql = "SELECT a.* , b. `stage_name`
        FROM newelle a
        LEFT JOIN `users` b on a. `id_user` = b. `id`
        ORDER BY a. `id` DESC
        LIMIT 6
        ";
        $result = $this->db->query($sql);
        $newelles = [];

        while ($newelle = $result->fetch()) {
            $newelles[] = new Newelle($newelle);
        }
        return $newelles;
    }
    
    /**
     * Récupère toutes les newelles.
     * @return array : un tableau d'objets Newelle.
     */
    public function getAllNewelles() : array
    {
        $sql = "SELECT a.* , b. `stage_name`
        FROM newelle a
        LEFT JOIN `users` b on a. `id_user` = b. `id`
        ORDER BY a. `DATE_CREATION` DESC
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
     * Récupère les Newelles par son user.
     * @param int $idUser : l'idUser de la newelle.
     * @return array : un tableau d'objet newelles
     */
    public function getAllNewellesByUser(int $idUser) : ?array
    {
        $sql = "SELECT a. `id`, a. `id_user`, b. `stage_name`, a. `date_creation`, a. `date_update`, a. `content`, a. `title`, a. `audio`, a. `nwl_img`, a. `genre`, a. `duree`, a. `taille`, 
        CONCAT('<a href=\"index.php?action=showUpdateNewelleForm&id=',a. `id`,'\">Modifier</a>') AS `Modifier`, 
        CONCAT('<a href=\"index.php?action=detail&id=',a. `id`,'\">Voir</a>') AS `Voir`, 
        CONCAT('<a href=\"index.php?action=delete&id=',a. `id`,'\"','onclick=\'return confirm(\"Êtes-vous sûr de vouloir supprimer cette Newelle ?\")\'>Supprimer</a>') AS `Supprimer`
        FROM `newelle` a
        LEFT JOIN `users` b on a. `id_user` = b. `id`
        WHERE a. `id_user` = :id_user";

        $newellesUser = [];
        $result = $this->db->query($sql, ['id_user' => $idUser]);
        while ($newelle = $result->fetch()) {
            $newellesUser[] = new Newelle($newelle);
        }
        return $newellesUser;
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
            'genre' => $newelle->getGenre(),
            'duree' => $newelle->getDuree(),
            'taille' => $newelle->getTaille()
        ]);
    }

    /**
     * Modifie une newelle.
     * @param Newelle $newelle : la newelle à modifier.
     * @return void
     */
    public function updateNewelle(Newelle $newelle) : void
    {
        $sql = "UPDATE newelle SET title = :title, audio = :audio, content = :content, date_update = NOW(), nwl_img = :nwl_img, genre = :genre, duree = :duree, taille = :taille WHERE id = :id";
        $this->db->query($sql, [
            'title' => $newelle->getTitle(),
            'audio' => $newelle->getAudio(),
            'content' => $newelle->getContent(),
            'nwl_img' => $newelle->getNwlImg(),
            'genre' => $newelle->getGenre(),
            'duree' => $newelle->getDuree(),
            'taille' => $newelle->getTaille(),
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

    /**
     * Crée le nom d'un fichier uploadé en fonction de l'idUser et de l'id de la newelle
     *
     * @param [type] $idUser
     * @param [type] $id
     * @return string
     */
    public function fileName($idUser, $id):string
    {
        $sql = "SELECT id
                FROM newelle
                ORDER BY id DESC LIMIT 1";
        $result =$this->db->query($sql);
        if($id === "-1"){
            $idNewelle = $result->fetch()['id']+1;
        } else {
        $idNewelle = $id;}

        $fileName = $idUser . '-' . $idNewelle;

        return $fileName;
    }
}