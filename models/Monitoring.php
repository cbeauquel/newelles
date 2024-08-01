<?php

/**
 * Entité monitoring, un monitoring est défini par les champs
 * id, page_tracked, nb_views 
 */
 class Monitoring extends AbstractEntity 
 {
    private string $pageTracked;
    private string $views;
    //private int $nwlId;


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

    // /**
    //  * Setter pour la propriété nwlID (id de la newelle)
    //  *
    //  * @param integer $nwlId
    //  * @return void
    //  */
    // public function setNwlId(int $nwlId):void
    // {
    //     $this->nwlId = $nwlId;
    // }

    // /**
    //  * Getter pour la propriété nwlId (id de la newelle)
    //  *
    //  * @return integer
    //  */
    // public function getNwlId():int
    // {
    //     return $this->nwlId;
    // }
 }