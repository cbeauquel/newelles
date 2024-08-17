<?php
/**
 * Classe qui gère les feedbacks
 */
class FeedbackManager extends AbstractEntityManager 
{
/**
     * Ajoute un feedback.
     * @param Feedback $feedback : le feedback à ajouter.
     * @return void
     */
    public function addFeedback(Feedback $feedback) : void
    {
        $sql = "INSERT INTO feedback (nwl_id, nick_name, thumb_up, comment, date_comment) 
        VALUES (:nwl_id, :nick_name, :thumb_up, :comment, NOW())";
        $this->db->query($sql, [
            'nwl_id' => $feedback->getNwlId(),
            'nick_name' => $feedback->getNickName(),
            'thumb_up' => $feedback->getThumbUp(),
            'comment' => $feedback->getComment(),
        ]);
    }

    /**
     * Méthode pour récupérer les feedbacks pour affichage par newelle
     *
     * @param integer $id
     * @return array
     */
    public function getFeedbacksByNewelleId(int $id):array
    {
        $sql="SELECT * 
              FROM feedback 
              WHERE nwl_id = :nwl_id 
              ORDER BY date_comment DESC";

        $result = $this->db->query($sql, ['nwl_id' => $id]);
        $feedbacks = [];

        while ($feedback = $result->fetch()) {
            $feedbacks[] = new Feedback($feedback);
        }
        return $feedbacks;
    }
    /**
     * Méthode de récupération des feedbacks par utilisateur
     *
     * @param int $id
     * @return array
     */
    public function getFeedbacksByUserId(int $id):array
    {
        $sql="SELECT a. *, b. title AS Nwl_Title
              FROM `feedback` a
              LEFT JOIN `newelle` b on a. `nwl_id` = b. `id`        
              WHERE b. `id_user` = :id_user ORDER BY a. `nwl_id`";

        $result = $this->db->query($sql, ['id_user' => $id]);
        $userFeedbacks = [];

        while ($userFeedback = $result->fetch()) {
            $userFeedbacks[] = new Feedback($userFeedback);
        }
        return $userFeedbacks;
    }

    /**
     * Méthode qui affiche le nombre de coups de pouces dans le compte utilisateur
     *
     * @param integer $id
     * @return string|null
     */
    public function countThumbupsByUserId(int $id):?string
    {
        $sql="SELECT SUM(`thumb_up`) 
              FROM `feedback` a
              left join newelle b ON a. nwl_id = b. id
              where b. `id_user` = :id_user";
        $result = $this->db->query($sql, ['id_user' => $id]);
        $thumbups = $result->fetch();
        $thumbupsCount = $thumbups['SUM(`thumb_up`)'];
        return $thumbupsCount;
    }


    /**
     * Supprime un Feedback.
     * @param int $id : l'id du feedback à supprimer.
     * @return void
     */
    public function deleteFeedback(int $id) : void
    {
        $sql = "DELETE FROM feedback WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
}