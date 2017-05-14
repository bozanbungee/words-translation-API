<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{


    public function getEnToBgString($string){
        $client = new Client();
        $res = $client->request('POST', 'http://www.transltr.org/api/translate', [
            'form_params' => [
                'text' => $string,
                'to' => 'BG',
                'from' => 'EN'
            ],
            'headers' => [

                'Accept'  => 'application/json',

            ]
        ]);

        $array = json_decode($res->getBody()->getContents(), true);
        return $array['translationText'];
    }

}
