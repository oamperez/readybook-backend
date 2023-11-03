<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Validator;
use DB;

class CyberfuelService
{
    private $client;

    public function __construct(){
        $this->client = new Client([
            'base_uri' => env('CYBERFUEL_BASE_URI'),
        ]);
    }

    public function makeXML($params):string
    {   
        try{
            $response = $this->client->request('POST', "/cyberfuel/makeXML", $params);
            return $response->getBody()->getContents();
        }catch(GuzzleException $e){
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
