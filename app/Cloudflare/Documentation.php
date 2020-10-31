<?php
/**
 *
 * @package cloudflare-cli
 * @author Sergei Miami <miami@blackcrystal.net>
 */

namespace App\Cloudflare;

use DiDom\Document;
use Illuminate\Support\Facades\Http;

class Documentation
{

    const FILENAME = 'documentation.html';

    private $client, $parser;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.cloudflare.com');
    }

    public function download()
    {
        if (!file_exists(self::FILENAME))
            file_put_contents(self::FILENAME, $this->client->get('/'));
        return $this;
    }

    public function parse()
    {
        if (is_null($this->parser))
        {
            $this->parser = new Document(self::FILENAME,true);
        }
        return $this->parser;
    }



}
