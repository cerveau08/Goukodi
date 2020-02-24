<?php

// src/EventListener/JWTCreatedListener.php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Config\Definition\Exception\Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    ############################## CONTROL BLOCKED ACCOUNT USER ###########################
    ############################## BY SON EXCELLENCE WADE   ####################

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();

    //Bloque le compte d'utilisateur  si la metode getIsActive() est egale a false BY SON EXCELLENCE WADE
        if($user->getIsActive() == false){

     throw new  CustomUserMessageAuthenticationException('Votre compte a été bloqué');
           
        }

        //Bloque le compte d'utilisateur du Partenaire et tous ses utilisateurs BY SON EXCELLENCE WADE

        if($user->getPartenaire() != null){

            if($user->getPartenaire()->getUserPartenaire()[0]->getIsActive() == false){

                throw new  CustomUserMessageAuthenticationException("Le Compte d'utilisateur du Partenaire ".$user->getPartenaire()->getRaisonSociale(). " a été bloqué" );
            }

        }
        if($this->aff->findCompteAffectTo($user) != []){
            $aujourd = date('Y-m-d');
        $aujourd=date('Y-m-d', strtotime($aujourd));
        //echo $paymentDate; // echos today!
        //Dernier Affectations
        $affects=$this->aff->findCompteAffectTo($user)[0];
        $debut=$affects->getDateDebut();
        $fin=$affects->getDateFin();
        $debut=date_format($debut,"Y-m-d");
        $fin=date_format($fin,"Y-m-d");
        if (!(($aujourd >= $debut) && ($aujourd <= $fin))){
           throw new Exception("Vous etes pas associé à aucun compte ");
        }
        /*else{
            throw new Exception("Votre Compte utilsateur n'est affecté à aucun compte");
         }*/
        }
 
        // merge with existing event data
        $payload = array_merge(
            $event->getData(),
            [
                'password' => $user->getPassword()
            ]
        );

        $event->setData($payload);
    }
}