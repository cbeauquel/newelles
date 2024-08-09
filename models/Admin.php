<?php

/**
 * Entité Admin : un admin est défini par
 * un id, un email, un password, un prénom (firstname), un nom (name), une bio, un statut (admin oui/non) et une image de profil.
 */ 
class Admin extends User 
{
    private bool $isAdmin = false;

    /**
     * Setter pour isadmin.
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin) : void 
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * Getter pour isadmin.
     * @return bool
     */
    public function getIsAdmin() : bool
    {
        return $this->isAdmin;
    }

}