<?php

/** 
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserManager extends AbstractEntityManager 
{
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
     * @param User $user
     * @return void
     */
    public function updateUser(User $user) : void
    {
        $sql = "UPDATE users SET :name, :first_name, :stage_name, :email, :password, :bio, :is_admin, :usr_img";
        $this->db->query($sql, [
            'name' => $user->getName(),
            'first_name' => $user->getFirstName(),
            'stage_name' => $user->getStageName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'bio' => $user->getBio(),
            'is_admin' => $user->getIsAdmin(),
            'usr_img' => $user->getUsrImg()
        ]);
    }
}