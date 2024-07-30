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

    public function getFeedbacksByNewelleId($id):array
    {
        $sql="SELECT * FROM feedback WHERE nwl_id = :nwl_id ORDER BY date_comment DESC";

        $result = $this->db->query($sql, ['nwl_id' => $id]);
        $feedbacks = [];

        while ($feedback = $result->fetch()) {
            $feedbacks[] = new Feedback($feedback);
        }
        return $feedbacks;
    }
}