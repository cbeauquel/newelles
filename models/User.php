<?php

/**
 * Entité User : un user est défini par
 * un id, un email, un password, un prénom (firstname), un nom (name), une bio et une image de profil.
 */ 
class User extends AbstractEntity 
{
    private string $email = "";
    private string $password = "";
    private string $firstName = "";
    private string $stageName = "";
    private string $name = "";
    private ?string $bio = "";
    private ?string $usrImg = "";
    private string $modifier = "";
    private string $supprimer = "";

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
    public function getBio(int $length = -1) : ?string 
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $bio = mb_substr($this->bio, 0, $length);
            if (strlen($this->bio) > $length) {
                $bio .= "...";
            }
            return $bio;
        }
        return $this->bio;
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
  
    /**
     * Setter pour le lien "modifier".
     * @param string $modifier
     */
    public function setModifier(string $modifier) : void 
    {
        $this->modifier = $modifier;
    }

    /**
     * Getter pour le lien modifier.
     * @return string
     */
    public function getModifier() : string 
    {
        return $this->modifier;
    }
        
    /**
     * Setter pour le lien "supprimer".
     * @param string $supprimerr
     */
    public function setSupprimer(string $supprimer) : void 
    {
        $this->supprimer = $supprimer;
    }

    /**
     * Getter pour le lien voir.
     * @return string
     */
    public function getSupprimer() : string 
    {
        return $this->supprimer;
    }
}