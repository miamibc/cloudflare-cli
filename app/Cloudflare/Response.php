<?php
/**
 *
 * Wrapper for Cloudflare\Client\\Result
 *
 * @package cloudflare-cli
 * @author Sergei Miami <miami@blackcrystal.net>
 */

namespace App\Cloudflare;

class Response
{

    private $result;

    public function __construct(\Illuminate\Http\Client\Response $response )
    {
        file_put_contents('debug.json', '');
        $this->add($response);
    }

    public function success()
    {
        return $this->result['success'];
    }

    public function result()
    {
        return $this->result['result'];
    }

    public function resultJson()
    {
        return json_encode( $this->result(), JSON_PRETTY_PRINT );
    }

    public function errors()
    {
        return $this->result['errors'];
    }

    public function errorsJson()
    {
        return json_encode( $this->errors(), JSON_PRETTY_PRINT );
    }

    public function add( \Illuminate\Http\Client\Response $response )
    {
        if (is_null($this->result))
        {
            $this->result['result'] = $response['result'];
            $this->result['errors'] = $response['errors'];
            $this->result['success'] = $response['success'];
        }
        else
        {
            $this->result['result'] = array_merge( $this->result['result'], $response['result'] );
            $this->result['errors'] = array_merge( $this->result['errors'], $response['errors'] );
            $this->result['success'] = $response['success'];
        }
        $content = json_encode( $response->json(), JSON_PRETTY_PRINT) . PHP_EOL . PHP_EOL;
        file_put_contents('debug.json', $content , FILE_APPEND);
    }


}
