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
}