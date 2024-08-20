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
        $hCaptcha = utils::request('h-captcha-response');

        if (empty($comment) || empty($rating) || empty($nickName))
        {
            throw new exception("Tous les champs sont obligatoires. 3");
        }

        // on vérifie les données du captcha
        if(isset($hCaptcha) && !empty($hCaptcha))
        {
              $secret = H_CAPTCHA;
              $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify?secret='.$secret.'&response='.$hCaptcha.'&remoteip='.$_SERVER['REMOTE_ADDR']);
              $responseData = json_decode($verifyResponse);
              if($responseData->success)
              {
                  $succMsg = 'Your request have submitted successfully.';
              }
              else
              {
                throw new exception("La vérification n\' a pas aboutie, recommencez le captcha.");
              }
         }
         else
         {
           throw new exception("Vous devez remplir le captcha.");
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