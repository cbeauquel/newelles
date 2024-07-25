<?php

/**
 * Entité User : un user est défini par
 * un id, un email, un password, un prénom (firstname), un nom (name), une bio, un statut (admin oui/non) et une image de profil.
 */ 
class User extends AbstractEntity 
{
    private string $email;
    private string $password;
    private string $firstName;
    private string $stageName;
    private string $name;
    private ?string $bio;
    private bool $isAdmin = false;
    private ?string $usrImg;

    /**
     * Setter pour l'email.
     * @param string $email
     */
    public function setEmail(string $email) : void 
    {
        $this->email = $email;
    }

    /**
     * Getter pour l'email.
     * @return string
     */
    public function getEmail() : string 
    {
        return $this->email;
    }

    /**
     * Setter pour le password.
     * @param string $password
     */
    public function setPassword(string $password) : void 
    {
        $this->password = $password;
    }

    /**
     * Getter pour le password.
     * @return string
     */
    public function getPassword() : string 
    {
        return $this->password;
    }

    /**
     * Setter pour le nom.
     * @param string $name
     */
    public function setName(string $name) : void 
    {
        $this->name = $name;
    }

    /**
     * Getter pour le password.
     * @return string
     */
    public function getName() : string 
    {
        return $this->name;
    }

    /**
     * Setter pour le firstname.
     * @param string $firstName
     */
    public function setFirstName(string $firstName) : void 
    {
        $this->firstName = $firstName;
    }

    /**
     * Getter pour le firstName.
     * @return string
     */
    public function getFirstName() : string 
    {
        return $this->firstName;
    }

    /**
     * Setter pour le stagename.
     * @param string $stagename
     */
    public function setStageName(string $stageName) : void 
    {
        $this->stageName = $stageName;
    }

    /**
     * Getter pour le stagename.
     * @return string
     */
    public function getStageName() : string 
    {
        return $this->stageName;
    }

    /**
     * Setter pour la bio.
     * @param string $bio
     */
    public function setBio(?string $bio) : void 
    {
        $this->bio = $bio;
    }

    /**
     * Getter pour la bio.
     * @return string
     */
    public function getBio() : ?string 
    {
        return $this->bio;
    }

    /**
     * Setter pour la isadmin.
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin) : void 
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * Getter pour la isadmin.
     * @return bool
     */
    public function getIsAdmin() : bool 
    {
        return $this->isAdmin;
    }

    /**
     * Setter pour l'usrimg.
     * @param string $usrimg
     */
    public function setUsrImg(?string $usrImg) : void 
    {
        $this->usrImg = $usrImg;
    }

    /**
     * Getter pour l'usrimg.
     * @return string
     */
    public function getUsrImg() : ?string 
    {
        return $this->usrImg;
    }
}