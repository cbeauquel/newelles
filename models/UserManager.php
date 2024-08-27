<?php

/** 
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserManager extends AbstractEntityManager 
{
    /**
     * Méthode qui extrait tous les comptes utilisateurs
     *
     * @return array
     */
    public function getAllProfiles(): array
    {
        $sql = "SELECT * FROM users LIMIT 4";        
        $result = $this->db->query($sql);
        $profiles = [];

        while ($profile = $result->fetch()) {
            $profiles[] = new User($profile);
        }
        return $profiles;
    }

    /**
     * Récupère un user par son email.
     * @param string $email
     * @return ?User
     */
    public function getUserByLogin(string $email) : ?User 
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Récupère un user par son id_user.
     * @param int $id
     * @return ?User
     */
    public function getUserById(int $idUsr) : ?User 
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $idUsr]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * crée un nouvel utilisateur
     *
     * @param User $user
     * @return void
     */
    public function addUser(User $user) : void
    {      
        $sql = "INSERT INTO users (`name`, `first_name`, `stage_name`, `email`, `password`) VALUES (:name, :first_name, :stage_name, :email, :password)";
        $this->db->query($sql, [
            'name' => $user->getName(),
            'first_name' => $user->getFirstName(),
            'stage_name' => $user->getStageName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);
    }

    /**
     * Modifie un utilisateur
     *
     * @param User $rofile
     * @return void
     */
    public function updateUser(User $profile) : void
    {
        $sql = "UPDATE users SET name = :name, first_name = :first_name, stage_name = :stage_name, email = :email, bio = :bio, usr_img = :usr_img 
        WHERE id = :id";
        $this->db->query($sql, [
            'name' => $profile->getName(),
            'first_name' => $profile->getFirstName(),
            'stage_name' => $profile->getStageName(),
            'email' => $profile->getEmail(),
            'bio' => $profile->getBio(),
            'usr_img' => $profile->getUsrImg(),
            'id' => $profile->getId()  
        ]);
    }

    /**
     * Supprime un Neweller.
     * @param int $id : l'id du neweller à supprimer.
     * @return void
     */
    public function deleteUser(int $id) : void
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Update Token pour la réinitialisation du mot de passe
     *
     * @param integer $id
     * @param string $token
     * @return void
     */
    public function addToken(int $id, string $token) : void
    {
        $sql = "UPDATE users SET token = :token, valid_time = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'id' => $id,
            'token' => $token]);
    }

    /**
     * extract Token et valid_time pour la réinitialisation du mot de passe
     *
     * @param string $token
     * @return $array
     */
    public function getToken(string $token) : ?array
    {
        $sql = "SELECT id, token, valid_time FROM users WHERE token = :token";
        $result = $this->db->query($sql, [
            'token' => $token]);
        $token = [];
        $token = $result->fetch();
        if ($token) {
            return $token;
        }
        return null;
    }


    public function updatePassword(int $id, string $password) : void
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $this->db->query($sql, [
            'id' => $id,
            'password' => $password]);
    }

}    