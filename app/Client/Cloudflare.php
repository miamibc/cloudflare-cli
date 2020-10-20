<?php
/**
 *
 * @package cloudflare-cli
 * @author Sergei Miami <miami@blackcrystal.net>
 */

namespace App\Client;

use Illuminate\Support\Facades\Http;

class Cloudflare
{

    private $client;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.cloudflare.com/client/v4/')
            ->withToken(env('API_TOKEN'))
            ->contentType('application/json')
            ->accept('application/json')
            ->timeout(2)
            ;
    }

    public function verify()
    {
        $result = $this->client->get( '/user/tokens/verify');
        return $result->ok() ? $result['result'] : false;
    }

    public function development_mode( $zone, $onoff )
    {
        $allowed = ['on'=>'on', 'yes'=>'on', 'true'=>'on', 'y' => 'on', true => 'on',
                    'off'=>'off', 'no'=>'off', 'false'=>'off', 'n' => 'off', false => 'off'];

        if (!isset($allowed[$onoff]))
            throw new Exception('Allowed: ' . implode( ', ', array_keys( $allowed )));

        $result = $this->client->patch("/zones/$zone/settings/development_mode", ['value' => $allowed[$onoff]]);
        return $result->ok() ? $result['result'] : false;
    }


}
