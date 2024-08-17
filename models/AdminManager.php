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
        LEFT JOIN `users` b ON a. `id_user` = b. `id`
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
        $sql = "SELECT b. title AS `nwlTitle`, a. *, c. stage_name,
        CONCAT('<a href=\"index.php?action=adminFeedbackDelete&id=',a. `id`,'\"','onclick=\'return confirm(\"Êtes-vous sûr de vouloir supprimer ce Feedback ?\")\'>Supprimer</a>') AS `Supprimer`
        FROM `feedback` a
        LEFT JOIN `newelle` b ON a. `nwl_id` = b. `id`
        LEFT JOIN `users` c ON b. `id_user` = c. `id`
        ORDER BY b. `id`";

        $adminFeedbacks = [];
        $result = $this->db->query($sql);
        while ($feedback = $result->fetch()) {
            $adminFeedbacks[] = new Feedback($feedback);
        }
        return $adminFeedbacks;
    }

    /**
     * Méthode permettant de récupérer le nombre de newelles
     *
     * @return integer
     */
    public function getNewellesCount(): array
    {
        $sql = "SELECT COUNT('id') AS `Number of Newelles`
                FROM newelle";
        $nbNewelles = 0;
        $result = $this->db->query($sql);
        $nbNewelles = $result->fetch();

        return $nbNewelles;
    }

    /**
     * Méthode permettant d'afficher le nombre de newellers
     *
     * @return integer
     */
    public function getNewellersCount(): array
    {
        $sql = "SELECT COUNT('id') AS `Number of Newellers`
                FROM users";
        $nbNewellers = 0;
        $result = $this->db->query($sql);
        $nbNewellers = $result->fetch();

        return $nbNewellers;
    }

    public function getFeedbacksCount():array
    {
        $sql = "SELECT COUNT('id') AS `Number of Feedbacks`
                FROM feedback";
        $nbFeedbacks = 0;
        $result = $this->db->query($sql);
        $nbFeedbacks = $result->fetch();

        return $nbFeedbacks;

    }

    /**
     * Méthode permettant de récupérer la newelle la plus consultée
     *
     * @return integer
     */
    public function getPopularNewelle():array
    {
        $sql = "SELECT `title`, `nwl_id`, `pouces`, `views`, `commentaires`
                FROM(
                    SELECT b. `title` AS `title`, a. `nwl_id` AS `nwl_id`, round(avg(a. `thumb_up`),1) AS `pouces`, count(distinct(c. `id`)) AS `views`, count(distinct(a. `id`)) AS `commentaires`
                    FROM `feedback` a 
                    LEFT JOIN `newelle` b ON a. `nwl_id` = b. `id`
                    LEFT JOIN `connections` c ON b. `id` = c. `nwl_id`
                    GROUP BY a. `nwl_id`
                    ORDER BY `pouces` DESC) AS `moyennes`
                limit 1";

        $result = $this->db->query($sql);
        $bestNewelle = [];

        $bestNewelle = $result->fetch();

        return $bestNewelle;
    }

    /**
     * Méthode pour afficher le neweller le plus actif (celui ayant publié le plus de newelles)
     *
     * @return array
     */
    public function getBestNeweller():array
    {
        $sql = "SELECT `stagename`, `newelles`, `pouces`, `views`, `commentaires` 
                FROM( 
                    SELECT d. `stage_name` AS `stagename`, count(distinct(b. `id`)) AS `newelles`, round(avg(a. `thumb_up`),1) AS `pouces`, count(distinct(c. `id`)) AS `views`, count(distinct(a. `id`)) AS `commentaires` 
                    FROM `feedback` a 
                    LEFT JOIN `newelle` b ON a. `nwl_id` = b. `id` 
                    LEFT JOIN `connections` c ON b. `id` = c. `nwl_id` 
                    LEFT JOIN `users` d ON b. `id_user` = d. `id` 
                    GROUP BY d. `stage_name` 
                    ORDER BY `newelles` DESC) AS `moyennes` 
                    LIMIT 1";

        $result = $this->db->query($sql);
        $bestNeweller = [];

        $bestNeweller = $result->fetch();

        return $bestNeweller;
    }

    /**
     * Méthode permettant d'afficher le lecteur le plus actif (nombre de feedbacks publiés)
     *
     * @return array
     */
    public function getBestReader():array
    {
        $sql = "SELECT `nickname`, `newelles`, `pouces`, `commentaires`
                FROM( 
                    SELECT a.`nick_name` AS `nickname`, COUNT(DISTINCT(b.`id`)) AS `newelles`, SUM(a. thumb_up) AS `pouces`, COUNT(DISTINCT(a.`id`)) AS `commentaires`
                    FROM `feedback` a 
                    LEFT JOIN `newelle` b ON a. `nwl_id` = b. `id` 
                    GROUP BY `nickname`
                    ORDER BY `newelles` DESC) AS `moyennes` 
                    LIMIT 1";

        $result = $this->db->query($sql);
        $bestReader = [];

        $bestReader = $result->fetch();

        return $bestReader;
    }

}