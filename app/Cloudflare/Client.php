<?php
/**
 *
 * @package cloudflare-cli
 * @author Sergei Miami <miami@blackcrystal.net>
 */

namespace App\Cloudflare;

use Illuminate\Support\Facades\Http;

class Client
{

    private $client, $response;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.cloudflare.com/client/v4')
                            ->withToken(env('API_TOKEN'))
                            ->contentType('application/json')
                            ->accept('application/json')
                            ->timeout(2)
            //->withOptions(['debug' => true, ])
        ;
    }

    public function request( $method, $url, $params = [])
    {
        // echo "$method $url " . json_encode($params) . PHP_EOL;
        $result = $this->client->$method( $url, $params);
        $this->response = $response = new Response($result);

        // load other pages, if needed
        if ( isset($result['result_info']['total_pages']))
        {
            for ($page = 2; $page <= $result['result_info']['total_pages']; $page++)
            {
                $params['page'] = $page;
                // echo "$method $url " . json_encode($params) . PHP_EOL;
                $result = $this->client->$method( $url, $params);
                if ( !$result->ok() ) return $response;
                $response->add($result);
            }
        }

        return $response;
    }

    public function response()
    {
        return $this->response;
    }

    public function client()
    {
        return $this->client;
    }



}
