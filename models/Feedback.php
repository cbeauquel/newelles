<?php
/**
 * Entité Feedback, un feedback est défini par les champs 
 * id, nwl_id, nickname, thumbup, comment, date_comment
 */
class Feedback extends AbstractEntity
{
    private int $nwlId;
    private string $nickName;
    private int $thumbUp = 0;
    private string $comment = "";
    private ?DateTime $dateComment = null;

    /**
     * Setter pour la propriété nwlID (id de la newelle)
     *
     * @param integer $nwlId
     * @return void
     */
    public function setNwlId(int $nwlId):void
    {
        $this->nwlId = $nwlId;
    }

    /**
     * Getter pour la propriété nwlID (id de la newelle)
     *
     * @return integer
     */
    public function getNwlId():int
    {
        return $this->nwlId;
    }

    /**
     * Setter pour la propriété nickname (pseudo)
     *
     * @param string $nickName
     * @return void
     */
    public function setNickName(string $nickName):void
    {
        $this->nickName = $nickName;
    }
    
    /**
     * Getter pour la propriété nickname (pseudo)
     *
     * @return string
     */
    public function getNickName():string
    {
        return $this->nickName;
    }

    /**
     * Setter pour la propriété thumbUp (rating)
     *
     * @param integer $thumbUp
     * @return void
     */
    public function setThumbUp(int $thumbUp):void
    {
        $this->thumbUp = $thumbUp;
    }

    /**
     * Getter pour la propriété  thumbUp (rating)
     *
     * @return integer
     */
    public function getThumbUp():int
    {
        return $this->thumbUp;
    }

  /**
     * Setter pour la propriété comment (texte du commentaire)
     *
     * @param string $Comment
     * @return void
     */
    public function setComment(string $Comment):void
    {
        $this->Comment = $Comment;
    }
    
    /**
     * Getter pour la propriété Comment (pseudo)
     *
     * @return stringComment
     */
    public function getComment():string
    {
        return $this->Comment;
    }

    /**
     * Setter pour la date de commentaire. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateComment
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateComment(string|DateTime $dateComment, string $format = 'Y-m-d H:i:s') : void 
    {
        if (is_string($dateComment)) {
            $dateComment = DateTime::createFromFormat($format, $dateComment);
        }
        $this->dateComment = $dateComment;
    }

    /**
     * Getter pour la date de création.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime.
     * @return DateTime
     */
    public function getDateComment() : DateTime 
    {
        return $this->dateComment;
    }
}
