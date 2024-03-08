<?php
// src/Service/MessageGenerator.php
namespace App\Service;

use Twilio\Rest\Client;

class SmsGenerator
{
    
    public function SendSms(string $number, string $name, string $text)
    {

        
        
        $accountSid = $_ENV['AC085cf09c31bd545f73bdc62e700a48d4'];  //Identifiant du compte twilio
        $authToken = $_ENV['a8ea195c6ac4c1616201aef94d9d6c2c']; //Token d'authentification
        $fromNumber = $_ENV['+17078731627'];
         // Numéro de test d'envoie sms offert par twilio

        $toNumber = $number; // Le numéro de la personne qui reçoit le message
        $message = ''.$name.' vous a envoyé le message suivant:'.' '.$text.''; //Contruction du sms

        //Client Twilio pour la création et l'envoie du sms
        $client = new Client($accountSid, $authToken);

        $client->messages->create(
            $toNumber,
            [
                'from' => $fromNumber,
                'body' => $message,
            ]
        );


    }
}