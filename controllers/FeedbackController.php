<?php 
/**
 * Classe controller qui gère l'affichage des feedbacks (commentaire et ratings)
 */
class FeedbackController 
{
    public function addFeedback():void
    {
        // on vérifie les données du formulaire
        $comment = utils::request('comment');
        $rating = (int)utils::request('rating');
        $nickName = utils::request('nickname');
        $nwlId = utils::request('nwlId');

        if (empty($comment) || empty($rating) || empty($nickName))
        {
            throw new exception("Tous les champs sont obligatoires. 3");
        }

        //on crée l'objet feedback
        $feedback = new Feedback([
            'comment' => $comment,
            'thumbUp' => $rating,
            'nickName' => $nickName,
            'nwlId' => $nwlId,
        ]);
        // On ajoute le feedback.
        $feedbackManager = new FeedbackManager();
        $feedbackManager->addFeedback($feedback);

        // On redirige vers la page du compte utilisateur.
        Utils::redirect("detail&id=" . $nwlId);
    }

 
}