<?php
/**
 * Entité Newelle, une newelle est définie par les champs 
 * id, id_user, date_creation, title, audio, content, nwl_img
 */
class Newelle extends AbstractEntity
{
    private int $idUser;
    private string $stageName;
    private ?DateTime $dateCreation = null;   
    private ?DateTime $dateUpdate = null;
    private string $title = "";
    private string $audio = ""; 
    private string $content = "";
    private string $nwlImg = "";
    private string $genre = "";
    private int $duree = 0;
    private int $taille = 0;



    /**
     * Fonction setter pour l'id Utilisateur 
     *
     * @param integer $idUser
     * @return void
     */
    public function setIdUser(int $idUser) :void
    {
        $this->idUser = $idUser;
    }
    /**
     * Getter pour l'id utilisateur
     *
     * @return integer
     */
    public function getIdUser() :int
    {
        return $this->idUser;
    }

    /**
     * Setter pour le stageName.
     * @param string $stageName
     */
    public function setStageName(string $stageName) : void 
    {
        $this->stageName = $stageName;
    }


    /**
     * Getter pour le stageName.
     * @return string
     */
    public function getStageName() : string 
    {
        return $this->stageName;
    }


    /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateCreation(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s') : void 
    {
        if (is_string($dateCreation)) {
            $dateCreation = DateTime::createFromFormat($format, $dateCreation);
        }
        $this->dateCreation = $dateCreation;
    }

    /**
     * Getter pour la date de création.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime.
     * @return DateTime
     */
    public function getDateCreation() : DateTime 
    {
        return $this->dateCreation;
    }

    /**
     * Setter pour la date de mise à jour. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateUpdate
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé.
     */
    public function setDateUpdate(string|DateTime $dateUpdate, string $format = 'Y-m-d H:i:s') : void 
    {
        if (is_string($dateUpdate)) {
            $dateUpdate = DateTime::createFromFormat($format, $dateUpdate);
        }
        $this->dateUpdate = $dateUpdate;
    }

    /**
     * Getter pour la date de mise à jour.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime ou null
     * si la date de mise à jour n'a pas été définie.
     * @return DateTime|null
     */
    public function getDateUpdate() : ?DateTime 
    {
        return $this->dateUpdate;
    }

    /**
     * Setter pour le titre.
     * @param string $title
     */
    public function setTitle(string $title) : void 
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitle() : string 
    {
        return $this->title;
    }

    /**
     * Setter pour le lien vers l'audio.
     * @param string $audio
     */
    public function setAudio(string $audio) : void 
    {
        $this->audio = $audio;
    }

    /**
     * Getter pour le lien vers l'audio.
     * @return string
     */
    public function getAudio() : string 
    {
        return $this->audio;
    }

    /**
     * Setter pour le contenu.
     * @param string $content
     */
    public function setContent(string $content) : void 
    {
        $this->content = $content;
    }
    
    /**
     * Getter pour le contenu.
     * Retourne les $length premiers caractères du contenu.
     * @param int $length : le nombre de caractères à retourner.
     * Si $length n'est pas défini (ou vaut -1), on retourne tout le contenu.
     * Si le contenu est plus grand que $length, on retourne les $length premiers caractères avec "..." à la fin.
     * @return string
     */
    public function getContent(int $length = -1) : string 
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($this->content, 0, $length);
            if (strlen($this->content) > $length) {
                $content .= "...";
            }
            return $content;
        }
        return $this->content;
    }

    /**
     * Setter pour le lien vers l'image.
     * @param string $nwlImg
     */
    public function setNwlImg(string $nwlImg) : void 
    {
        $this->nwlImg = $nwlImg;
    }

    /**
     * Getter pour le lien vers l'image.
     * @return string
     */
    public function getNwlImg() : string 
    {
        return $this->nwlImg;
    }

    
    /**
     * Setter pour le genre.
     * @param string $genre
     */
    public function setGenre(string $genre) : void 
    {
        $this->genre = $genre;
    }

    /**
     * Getter pour le le genre.
     * @return string
     */
    public function getGenre() : string 
    {
        return $this->genre;
    }

    /**
     * Setter pour la durée
     *
     * @return void
     */
    public function setDuree(int $duree) : void
    {
        $this->duree = $duree;
    }

    /**
     * getter pour la durée
     *
     * @return integer
     */
    public function getDuree() : int
    {
        return $this->duree;
    }


    /**
     * Setter pour la taille
     *
     * @return void
     */
    public function setTaille(int $taille) : void
    {
        $this->taille = $taille;
    }
    
    /**
     * getter pour la taille
     *
     * @return integer
     */
    public function getTaille() : int
    {
        return $this->taille;
    }
}