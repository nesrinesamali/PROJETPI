<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class MailjetService
{
    private $apiKey="d602347d3c3dfc4d34fd7370d5b457a3" ;  // Your MailJet API Key here
    private $secretKey="5aa228622e5a4bf4d81d35971e636777";    // Your MailJet Secret Key here
    public function sendMail( $content,$toEmail,$toName):void
    {
        $mj= new Client($this->apiKey,$this->secretKey,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "toumi.mohamedamine@esprit.tn",
                        'Name' => "cbnnnnnnn"
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName,
                        ]
                    ],
                    'TemplateID' => 5745155,
                    'TemplateLanguage' => true,
                    'Variables' => [
 
                        "content" => $content,
 
 
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
       
    }
    
}

?>