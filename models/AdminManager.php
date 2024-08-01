<?php

/** 
 * Classe AdminManager pour gérer les requêtes liées à l' administrateur et à l'authentification.
 */
class AdminManager extends UserManager 
{  
    /**
     * Récupère un user par son email.
     * @param string $email
     * @return ?Admin
     */
    public function getAdminByLogin(string $email) : ?Admin
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $admin = $result->fetch();
        if ($admin) {
            return new Admin($admin);
        }
        return null;
    }

    /**
    * Récupère un useradmin par son id_user.
    * @param int $id
    * @return ?Admin
    */
    public function getAdminById(int $idUsr) : ?Admin 
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $idUsr]);
        $admin = $result->fetch();
        if ($admin) {
            return new Admin($admin);
        }
        return null;
    }

    /**
     * Méthode qui extrait tous les comptes utilisateurs
     *
     * @return array
     */
    public function manageNewellers(): array
    {
        $sql = "SELECT *, 
        CONCAT('<a href=\"index.php?action=adminUpdateProfileForm&id=',`id`,'\">Modifier</a>') AS `Modifier`, 
        CONCAT('<a href=\"index.php?action=adminProfileDelete&id=',`id`,'\"','onclick=\'return confirm(\"Êtes-vous sûr de vouloir supprimer ce Newellers ?\")\'>Supprimer</a>') AS `Supprimer`
        FROM users WHERE is_admin = 0";        
        $result = $this->db->query($sql);
        $profiles = [];

        while ($profile = $result->fetch()) {
            $profiles[] = new User($profile);
        }
        return $profiles;
    }

    /**
     * Récupère les Newelles par user.
     * @return array : un tableau d'objet newelles
     */
    public function ManageNewelles() : ?array
    {
        $sql = "SELECT a. `id`, a. `id_user`, b. `stage_name`, a. `date_creation`, a. `date_update`, a. `content`, a. `title`, a. `audio`, a. `nwl_img`, a. `genre`, a. `duree`, a. `taille`, 
        CONCAT('<a href=\"index.php?action=adminUpdateNewelleForm&id=',a. `id`,'\">Modifier</a>') AS `Modifier`, 
        CONCAT('<a href=\"index.php?action=detail&id=',a. `id`,'\">Voir</a>') AS `Voir`, 
        CONCAT('<a href=\"index.php?action=delete&id=',a. `id`,'\"','onclick=\'return confirm(\"Êtes-vous sûr de vouloir supprimer cette Newelle ?\")\'>Supprimer</a>') AS `Supprimer`
        FROM `newelle` a
        LEFT JOIN `users` b on a. `id_user` = b. `id`
        ORDER BY a. `id_user`";

        $adminNewelles = [];
        $result = $this->db->query($sql);
        while ($newelle = $result->fetch()) {
            $adminNewelles[] = new Newelle($newelle);
        }
        return $adminNewelles;
    }

     /**
     * Récupère les Feedbacks par Newelles.
     * @return array : un tableau d'objet newelles
     */
    public function ManageFeedbacks() : ?array
    {
        $sql = "SELECT b. title, a. *, c. stage_name,
        CONCAT('<a href=\"index.php?action=adminFeedbackDelete&id=',a. `id`,'\"','onclick=\'return confirm(\"Êtes-vous sûr de vouloir supprimer ce Feedback ?\")\'>Supprimer</a>') AS `Supprimer`
        FROM `feedback` a
        LEFT JOIN `newelle` b on a. `nwl_id` = b. `id`
        LEFT JOIN `users` c on b. `id_user` = c. `id`
        ORDER BY b. `id`";

        $adminFeedbacks = [];
        $result = $this->db->query($sql);
        while ($feedback = $result->fetch()) {
            $adminFeedbacks[] = new Feedback($feedback);
        }
        return $adminFeedbacks;
    }

}