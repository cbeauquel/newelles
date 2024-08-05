<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id, page_tracked, nb_views 
 */
 class Monitoring extends AbstractEntity 
 {
    private string $pageTracked = "";
    private string $views = "";
    private string $ipAdress = "";
    private string $date = "";



    /**
     * Setter pour la page suivie.
     * @param string $pageTracked
     * @return void
    */
    public function setPageTracked(string $pageTracked): void 
    {
        $this->pageTracked = $pageTracked;
    }

    /**
     * Getter pour la page suivie.
     * @return string
     */
    public function getPageTracked(): string 
    {
        return $this->pageTracked;
    }

      /**
     * Setter pour le nombre de vues. 
     * @param int $vues
     */
    public function setViews(int $views) : void 
    {
        $this->views = $views;
    }

    /**
     * Getter pour le nombre de views. 
     * @return int
     */
    public function getViews() : int 
    {
        return $this->views;
    }

    /**
     * Setter pour l'adresse IP du visiteur
     * @param string $ipAdress
     */
    public function setIpAdress(string $ipAdress) : void 
    {
        $this->ipAdress = $ipAdress;
    }

    /**
     * Getter pour l'adresse IP du visiteur
     * @return string
     */
    public function getIpAdress() : string
    {
        return $this->ipAdress;
    }
    
    /**
     * Setter pour la date de connection. 
     */
    public function setDate(string $date) : void 
    {
        $this->date = $date;
    }

    /**
     * Getter pour la date de création.
     * @return string
     */
    public function getDate() : string
    {
        return $this->date;
    }

 }